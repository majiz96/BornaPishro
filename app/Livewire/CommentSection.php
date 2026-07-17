<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Product;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CommentSection extends Component
{
    public $text,$replyText,$showComment,$parent_id,$vote;

    public $commentable;
    public $reply = null;

    public $showed_reply = [];
    public $reply_text = 'نمایش پاسخ ها';

    public $comment_editing = null;
    public $timeLimit = 1800;

    public $commentCountDown = 0;
    public string $countDownMessage = '';

    public string $deleteConfirm = "آیا از حذف این نظر مطمئن هستید؟";


    public function mount($commentable)
    {
        $this->commentable = $commentable;
    }

    public function makeReply($id)
    {
        $this->reply = $id;
    }
    public function cancel()
    {
        $this->reply = null;
        $this->reset('replyText');
    }

    public function toggleLike(Comment $comment)
    {

        if(!auth()->check())
        {
            return redirect()->route('login');
        }

        $comment->LikedByUsers()->toggle(auth()->id());

    }

    public function toggleReplies($id)
    {
        if (in_array($id, $this->showed_reply))
        {
            $this->showed_reply = array_values(array_diff($this->showed_reply, [$id]));
        }
        else
        {
            $this->showed_reply[] = $id;
        }

        return $this->showed_reply;
    }

    public function editTimeLimit($comment): bool
    {
        $now = time();
        $created = strtotime($comment->created_at);

        if ($created === false)
        {
            return false;
        }

        return ($now - $created) <= $this->timeLimit;
    }

    public function editComment($id)
    {
        $this->comment_editing = $id;
        $comment = Comment::findOrFail($id);
        $this->text = $comment->text;
    }

    public function cancelEdit()
    {
        $this->comment_editing = null;
        $this->reset('text');
    }

    public function save()
    {
        if(auth()->check())
        {

            if ($this->comment_editing)
            {
                $this->validate([
                        'text' => 'required|string|max:1000'
                    ]
                    ,
                    [
                        'text.required'=>'متنی برای نظر خود ننوشته اید',
                        'text.string'=>'متن نظر معتبر نمی باشد',
                        'text.max'=>'نظر نوشته شده طولانی تر از ۱۰۰۰ حرف است',
                    ]);

                $comment = Comment::findOrFail($this->comment_editing) ;

                $comment->update([
                    'text'=>$this->text,
                ]);
                $this->reset('text','comment_editing');
            }
            else
            {
                $this->validate([
                        'text' => 'required|string|max:1000'
                    ]
                    ,
                    [
                        'text.required'=>'متنی برای نظر خود ننوشته اید',
                        'text.string'=>'متن نظر معتبر نمی باشد',
                        'text.max'=>'نظر نوشته شده طولانی تر از ۱۰۰۰ حرف است',
                    ]);

                $cooldownKey = 'comment-cooldown:'. (auth()->id() ?? request()->ip());
                $delayKey    =    'comment-delay:'. (auth()->id() ?? request()->ip());

                $expireAt = Cache::get($cooldownKey);

                if ($expireAt && now()->timestamp < $expireAt) {

                    $this->commentCountDown = $expireAt - now()->timestamp;
                    $this->countDownMessage = "لطفاً {$this->commentCountDown} ثانیه دیگر تلاش کنید.";

                    return;
                }
                else
                {
                    Comment::create([
                        'user_id'=>Auth::id(),
                        'text'=>$this->text,
                        'commentable_id'=>$this->commentable->id,
                        'commentable_type'=>get_class($this->commentable),
                        'show'=> Auth::user()->autoApprove() ? 1 : 0
                    ]);

                    $delay = Cache::get($delayKey, 20);

                    Cache::put(
                        $cooldownKey,
                        now()->timestamp + $delay,
                        now()->addSeconds($delay)
                    );

                    Cache::put(
                        $delayKey,
                        min($delay + 10, 60),
                        now()->addMinutes(10)
                    );

                    $this->reset('text','countDownMessage');
                }

            }
        }
        else
        {
            // Here we should show an error
        }

    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->deleteWithChildren();
    }

    public function saveReply()
    {
        $this->validate([
                'replyText'=>'required|string|max:1000',

            ]
            ,
            [
                'replyText.required'=>'متنی برای نظر خود ننوشته اید',
                'replyText.string'=>'متن نظر معتبر نمی باشد',
                'replyText.max'=>'نظر نوشته شده طولانی تر از ۱۰۰۰ حرف است'
            ]);

        Comment::create([
            'user_id'=>Auth::id(),
            'parent_id' => $this->reply,
            'text'=>$this->replyText,
            'commentable_id'=>$this->commentable->id,
            'commentable_type'=>get_class($this->commentable),
            'show'=> Auth::user()->autoApprove() ? 1 : 0
        ]);
        $this->reset('text',);

        $this->reset('replyText','reply');
    }

    #[Computed]
    public function comments()
    {
        return Comment::with([
            'Users',
            'parent',
            'children' => fn($q) => $q->visible(),
        ])
            ->visible()
            ->where('commentable_id', $this->commentable->id)
            ->where('commentable_type', get_class($this->commentable))
            ->where('parent_id', 0)
            ->get();
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}

@php
    $depth = $depth ?? 0;
    $colWidth = 12 - min($depth,6);
@endphp

<div class="row my-2 mx-auto">

    @if($depth > 0 )
        <div class="col-{{min($depth,6)}}"></div>
    @endif

    <div class="col-{{$colWidth}}  pt-2 px-2 mt-2 mx-auto
    {{$comment->Users->position_id !== 4 ? 'cs-navbar rounded-4 text-white' : 'rounded-4 border border-3'}}">

        <div class="row pt-2 px-2 mx-auto">
            <h5 class="col-xl-2"> {{ $comment->Users->name}}  {{ $comment->Users->lastname}}</h5>
            <div class="col-xl-6"></div>
            <small class="col-xl-4 text-start"> {{$comment->created_at->diffForHumans()}}</small>
        </div>

        <div class="row p-2 mx-auto"> {{$comment->text}} </div>


        <div class="row p-2">

            <div class="col-xl-1">
                <i class="bi-reply-fill" wire:click="makeReply({{$comment->id}})"></i>
            </div>
            <div class="col-xl-10"></div>

            <div class="col-xl-1">
                <small>{{$comment->LikedByUsers->count()}}</small>
                @if($comment->LikedByUsers->contains(auth()->id()))
                    <input type="checkbox" id="vote" class="d-none">
                    <label for="vote" wire:click="toggleLike({{$comment->id}})"><i class="bi-hand-thumbs-up-fill"></i></label>
                @else
                    <input type="checkbox" id="vote" class="d-none">
                    <label for="vote" wire:click="toggleLike({{$comment->id}})"><i class="bi-hand-thumbs-up"></i></label>
                @endif
            </div>

        </div>

        @if($reply && $reply == $comment->id)
            <form wire:submit.prevent="saveReply" class="row mt-3 p-3">

                <textarea id="text" class="form-control mx-auto" rows="2" wire:model.blur="replyText"></textarea>
                @error('text') <small class="text-danger"> {{$message}} </small> @enderror

                <button type="button" class="btn btn-danger mt-2 w-auto mx-auto" wire:click="cancel"> انصراف </button>
                <button type="submit" class="btn btn-primary mt-2 w-auto mx-auto"> ارسال </button>

            </form>
        @endif


    </div>

</div>



    @if($comment->children->isNotEmpty())

        <div class="row px-4">
            <small wire:click="toggleReplies({{$comment->id}})" class="delete-badge">
                {{in_array($comment->id,$showed_reply) ? 'بستن پاسخها' : 'نمایش پاسخها'.' ('.$comment->children->count().')' }}
            </small>
        </div>


        @if(in_array($comment->id,$showed_reply))
            @foreach($comment->children as $child)
                <div class="border-end border-3">
                    @include('livewire.comment-item',['comment'=>$child , 'depth'=> $depth+1])
                </div>
            @endforeach
        @endif

    @endif







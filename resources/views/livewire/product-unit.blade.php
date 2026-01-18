<div class="container">

    <div class="row mt-4 text-center"><h2>{{$product->name}}</h2></div>

    <form wire:submit.prevent="save" class="row mt-4 border rounded-4 p-2">

        <textarea id="text" class="form-control" rows="4" wire:model.blur="text"></textarea>
        @error('text') <small class="text-danger"> {{$message}} </small> @enderror

        <button type="submit" class="btn btn-primary mt-2 w-auto mx-auto"> ارسال </button>

    </form>

    <div class="row mt-4 p-3 border">

        @if($comments->isNotEmpty())

            @foreach($comments as $comment)

                @if($comment->parent_id == 0)


                <div class="comment row border mx-auto mt-2 mx-auto">

                    <div class="row border-bottom">
                        <h5 class="col-xl-2"> {{$name}} {{$lastname}}</h5>
                        <div class="col-xl-6"></div>
                        <h5 class="col-xl-4 text-start"> {{$comment->created_at}}</h5>
                    </div>

                    <div class="row p-2 border-bottom"> {{$comment->text}} </div>


                    <div class="row p-2 ">

                        <div class="col-xl-1">
                            <i class="bi-reply-fill" wire:click="makeReply({{$comment->id}})"></i>
                        </div>
                        <div class="col-xl-10"></div>

                        <div class="col-xl-1">
                            <small>{{$comment->votes}}</small>
                            @if($vote == 1)
                                <input type="checkbox" id="vote" class="d-none">
                                <label for="vote" wire:click="toggleVote({{$comment->id}})"><i class="bi-hand-thumbs-up-fill" ></i></label>
                            @else
                                <input type="checkbox" id="vote" class="d-none">
                                <label for="vote" wire:click="toggleVote({{$comment->id}})"><i class="bi-hand-thumbs-up" ></i></label>
                            @endif
                        </div>

                    </div>

                </div>

                    @endif

                    @if($reply && $reply == $comment->id)
                        <form wire:submit.prevent="saveReply" class="row mt-3">

                            <textarea id="text" class="form-control mx-auto" rows="2" wire:model.blur="replyText"></textarea>
                            @error('text') <small class="text-danger"> {{$message}} </small> @enderror

                            <button type="button" class="btn btn-danger mt-2 w-auto mx-auto" wire:click="cancel"> انصراف </button>
                            <button type="submit" class="btn btn-primary mt-2 w-auto mx-auto"> ارسال </button>

                        </form>
                    @endif

                    @if($comment->children->isNotEmpty())

                        @foreach($comment->children as $child)

                            @if($child->show == 1)
                                <div class="row border mt-2 mx-auto" dir="rtl">

                                    <div class="row border-bottom">
                                        <h5 class="col-xl-2"> {{$name}} {{$lastname}} </h5>
                                        <div class="col-xl-6"></div>
                                        <h5 class="col-xl-4 text-start"> {{$child->created_at}}  </h5>
                                    </div>

                                    <div class="row p-2 border-bottom"> {{$child->text}} </div>

                                    <div class="row p-2 ">

                                        <div class="col-xl-1">
                                            <i class="bi-reply-fill" wire:click="makeReply({{$child->id}})"></i>
                                        </div>

                                        <div class="col-xl-10"></div>

                                        <div class="col-xl-1">
                                            <small>{{$child->votes}}</small>
                                            @if($vote)
                                                <input type="checkbox" id="vote" class="d-none">
                                                <label for="vote" wire:model="vote({{$child->id}})"><i class="bi-hand-thumbs-up-fill" ></i></label>
                                            @else
                                                <input type="checkbox" id="vote" class="d-none">
                                                <label for="vote" wire:model="vote({{$child->id}})"><i class="bi-hand-thumbs-up" ></i></label>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @else

                            @endif


                        @endforeach

                    @endif


            @endforeach

        @else
            <div class="row text-center py-2 my-auto"> <h3 class="my-auto"> کامنتی برای این محصول ثبت نشده است </h3> </div>
        @endif

    </div>

</div>

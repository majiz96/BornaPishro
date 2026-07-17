<div>
    {{-- Comments --}}

    @auth
        <form wire:submit.prevent="save" class="row mt-4 border rounded-4 p-2">

            <textarea id="text" class="form-control" rows="4" wire:model.blur="text"></textarea>
            @error('text') <small class="text-danger"> {{$message}} </small> @enderror

            <button type="submit" class="col-auto btn btn-primary mt-2 w-auto mx-auto">
                {{$comment_editing ? 'ویرایش' : 'ارسال'}}
            </button>


            @if($comment_editing)
                <button type="button" class="col-auto btn btn-danger mt-2 w-auto mx-auto" wire:click="cancelEdit">
                    لغو ویرایش
                </button>
            @endif

            <small class="text-danger"> {{$countDownMessage}} </small>
        </form>
    @endauth

    @guest
        <div class="row mt-4 border rounded-4 p-2 text-center py-5 glass border border-white shadow-lg bg-white bg-opacity-10">

            <h5 class="mx-auto"> برای ثبت نظر
                <a class="text-primary text-decoration-none fw-bolder" href="{{route('login')}}"> وارد </a>
                شوید </h5>
        </div>
    @endguest


    <div class="row mt-4 p-sm-3 border rounded-4">

        @if($this->Comments->isNotEmpty())

            @foreach($this->Comments as $comment)
                @include('livewire.comment-item',['comment'=>$comment,'depth'=>0])
            @endforeach

        @else
            <div class="row text-center py-2 my-auto"> <h3 class="my-auto"> کامنتی برای این محصول ثبت نشده است </h3> </div>
        @endif

    </div>

</div>

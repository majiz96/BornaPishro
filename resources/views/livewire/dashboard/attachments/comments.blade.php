<div class="container">

    <div class="row text-center mx-auto">
        <div class="col-xl-5 my-auto"></div>
        <img class="col-xl-2 mx-auto" src="{{asset('storage/products/'.$model->image) }}"  alt="پیش نمایش">
        <div class="col-xl-5"></div>
    </div>

    <div class="row text-center my-2"><h1>{{$model->name ?? $model->title}}</h1></div>

    @if($this->Comments->isNotEmpty())

        <div class="row mt-3 px-0">

            @if(count($this->ShowedComments) == count($comments))
                <div class="col-xl-1 mt-2 text-start"><label for="show"> نمایش همه </label></div>
                <div class="col-xl-1 mt-2"><input type="checkbox" id="show" wire:change="showNone" checked></div>
            @else
                <div class="col-xl-2 mt-2 text-end"><label for="show"> نمایش {{count($this->ShowedComments)}} از {{count($comments)}} </label></div>
                <div class="col-xl-1 mt-2"><input type="checkbox" id="show" wire:change="showAll"></div>
            @endif


            @if(count($this->SeenComments) == count($comments))
                <div class="col-xl-1 mt-2 text-end"><label for="see"> دیدن همه </label></div>
                <div class="col-xl-1 mt-2 text-end"><input type="checkbox" id="see" wire:change="seeNone" checked></div>
            @else
                <div class="col-xl-1 mt-2 text-end"><label for="see"> نمایش {{count($this->SeenComments)}} از {{count($comments)}} </label></div>
                <div class="col-xl-1 mt-2 text-end"><input type="checkbox" id="see" wire:change="seeAll"></div>
            @endif

        </div>

        <div class="row mt-3 px-0">

        @foreach($this->Comments as $comment)
          <div class="row border rounded-4 mt-3 py-2">

            <div class="row border-bottom mx-auto">
                <h5 class="col-xl-2"> {{ $comment->Users->name}}  {{ $comment->Users->lastname}}</h5>
                <div class="col-xl-6"></div>
                <h5 class="col-xl-4 text-start"> {{$comment->created_at}}</h5>
            </div>

              <div class="row border-bottom mx-auto py-4">
                {{$comment->text}}
              </div>


              <div class="row mx-auto">
                <div class="col-xl-1 mt-2 text-start"><label for="show"> نمایش </label></div>
                <div class="col-xl-1 mt-2"><input type="checkbox" id="show" wire:change="toggleShow({{$comment->id}})" @checked($comment->show == 1)></div>

                <div class="col-xl-1 mt-2 text-start"><label for="see"> خوانده شد </label></div>
                <div class="col-xl-1 mt-2"><input type="checkbox" id="see" wire:change="toggleSee({{$comment->id}})" @checked($comment->see == 1)></div>

                  <button class="col-xl-auto btn btn-sm btn-danger mt-1" wire:click="delete({{$comment->id}})" wire:confirm="آیا از حذف این کامنت ( و پاسخهایش ) مطمئن هستید؟"> حذف </button>

              </div>

            </div>

        @endforeach
        </div>
    @else
        <div class="row text-center mt-3 border rounded-4 py-2"> <h2 class="text-danger"> کامنتی برای این محصول ثبت نشده است </h2> </div>
    @endif

</div>

<div>

    <form wire:submit.prevent="save" class="row py-2 my-5">
        <div class="col-xl-1 my-auto"> <label for="name"> نام جدول </label> </div>
        <div class="col-xl-3 my-auto">
            <input type="text" id="name" class="form-control" wire:model.live="name">
            @error('name') <small> {{$message}} </small> @enderror
        </div>


        <div class="col-xl-1 my-auto"> <label for="price"> قیمت </label> </div>
        <div class="col-xl-3 my-auto">
            <input type="text" id="price" class="form-control" wire:model.live="price">
            @error('price') <small> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-4 text-xl-start">

            @if($editing)
                <button type="button" class="btn btn-danger rounded-3 px-4 py-2 w-auto mx-3" wire:click="cancel"> انصراف </button>
            @endif

            <button type="submit" class="cs-button border-0 rounded-3 px-4 py-2 w-auto mx-3"> ذخیره </button>

        </div>

    </form>





    @if($this->specifications->isNotEmpty())

    <div class="row border text-center py-3 px-2">
        @foreach($this->specifications as $table)

            <a class="col-xl-3 text-decoration-none text-body px-4 my-auto">
                <div class="row border rounded-4 py-1 px-1 {{$active == $table->id ? 'cs-navbar' : ''}}">
                    <div class="col-8 delete-badge my-auto text-end" wire:click="select({{$table->id}})">{{$table->name}}</div>


                    <div class="col-1 pt-1"><i class="bi-trash-fill text-danger" wire:click="delete({{$table->id}})"
                                               wire:confirm="آیا از حذف جدول ({{$table->name}}) مطمئن هستید؟"></i></div>

                    <div class="col-1"></div>
                    <div class="col-1 pt-1"><i class="bi-pen-fill text-primary" wire:click="edit( {{$table->id}} )"></i></div>


                    @if($table->price)
                        <div class="col-12 bg-dark rounded-bottom-4 rounded-top-2 py-1 delete-badge" wire:click="select({{$table->id}})"> {{number_format($table->price)}} تومان </div>

                    @endif

                </div>
            </a>
        @endforeach
    </div>
    @else
        <div class="row text-center text-danger d-flex">
            <h3> هیچ جدولی ثبت نشده است </h3>
        </div>
    @endif

</div>

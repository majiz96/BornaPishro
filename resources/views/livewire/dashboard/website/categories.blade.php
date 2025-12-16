<div class="container">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

    <div class="card col-xl-3 px-0 rounded-start-0">

    <div class="card-header"><h3>زمینه ها</h3></div>

        <div class="card-body px-4">
            <form wire:submit.prevent="saveField" class="row">

                @csrf
                    <label for="field_name" class="form-label">نام زمینه</label>
                    <input type="text" id="field_name" class="form-control" wire:model.blur="field_name">
                    @error('field_name') <small class="text-danger">{{ $message }}</small> @enderror

                    <button type="submit" class="btn btn-secondary col-xl-3 my-3 mx-auto"> ثبت </button>

                    @if($editingField)
                    <button type="button" class="btn btn-danger h-auto col-xl-4 my-3 mx-auto" wire:click="cancelField"> انصراف </button>
                    @endif


            </form>

            <div class="row">

            @if($fields->isNotEmpty())

                @foreach($fields as $field)
                    <div class="row border rounded-3 my-2 mx-0 py-1 {{$fieldActive == $field->id ? 'bg-primary text-light' : ''}} ">

                            <div class="field col-xl-8 h5 my-auto" wire:click="selectField({{$field->id}})"> {{$field->name}} </div>

                            <div class="col-xl-1 mt-2"><i class="bi-trash-fill"
                            wire:confirm="آیا از حذف زمینه ی ({{$field->name}}) مطمئن هستید؟" wire:click="deleteField({{$field->id}})"></i></div>

                            <div class="col-xl-1"></div>
                            <div class="col-xl-1 mt-2"><i class="bi-pen-fill" wire:click="editField({{$field->id}})"></i></div>
                    </div>
                @endforeach

            @else
                <h4 class="text-center text-warning"> زمینه ای ثبت نشده است </h4>
            @endif


            </div>

        </div>

    </div>

    <div class="card col-xl-9 rounded-end-0 px-0">
        <div class="card-header text-center px-0"><h3> دسته بندی ها </h3></div>

        <div class="card-body">
            <form wire:submit.prevent="saveCategory" class="row">

                @csrf

                <div class="col-xl-4"></div>

                <div class="col-xl-4">
                    <label for="category_name" class="form-label">نام دسته</label>
                    <input type="text" id="category_name" class="form-control" wire:model.blur="category_name">
                    @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                @if($editingCategory)
                    <div class="col-xl-1 d-flex">
                        <button type="submit" class="btn btn-secondary mt-auto"> ثبت </button>
                    </div>

                    <div class="col-xl-1 d-flex">
                    <button type="button" class="btn btn-danger h-auto col-xl-1 mt-auto" wire:click="cancelField"> انصراف </button>
                    </div>

                    <div class="col-xl-2"></div>
                @else
                    <div class="col-xl-1 d-flex">
                        <button type="submit" class="btn btn-secondary mt-auto"> ثبت </button>
                    </div>

                    <div class="col-xl-4"></div>
                @endif


            </form>

            <div class="row text-center">

                @if($categories->isNotEmpty())
                @else
                    <h3 class="text-warning mt-5"> هیچ دسته ای ثبت نشده است </h3>
                @endif

            </div>
        </div>
    </div>

    </div>

</div>

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
                    <label for="field_name" class="form-label my-1">نام زمینه</label>
                    <input type="text" id="field_name" class="form-control my-1" wire:model.blur="field_name">
                    @error('field_name') <small class="text-danger">{{ $message }}</small> @enderror

                    <label for="field_route" class="form-label my-1">مسیر زمینه</label>
                    <input type="text" id="field_route" class="form-control my-1" wire:model.blur="field_route">
                    @error('field_route') <small class="text-danger">{{ $message }}</small> @enderror

                    <label for="field_logo" class="form-label my-1">تصویر نماد زمینه</label>
                    <input type="file" id="field_logo" class="form-control my-1" wire:model.live="field_logo">
                    @error('field_logo') <small class="text-danger">{{ $message }}</small> @enderror

                <div class="row">
                    @if($field_logo)
                        @if(is_string($field_logo) && $editingField)
                            <img src="{{asset('storage/field_logos/'.$field_logo) }}"  alt="پیش نمایش" height="100" class="rounded">
                        @else
                            <img src="{{$field_logo->temporaryUrl()}}"  alt="پیش نمایش"  height="100" class="rounded">
                        @endif
                    @endif
                </div>

                <div class="row py-1">
                    <label for="field_show" class="form-label col-auto my-1"> نمایش در منوی وبسایت </label>

                    @if($editingField)

                        @if($field_show == 0)
                            {{$field_show}}
                            <input type="checkbox" id="field_show" class="form-check col-auto my-1" value="1" wire:model.live="field_show">
                        @else
                            {{$field_show}}
                            <input type="checkbox" id="field_show" class="form-check col-auto my-1" value="0" wire:model.live="field_show" checked>
                        @endif

                    @else
                        <input type="checkbox" id="field_show" class="form-check col-auto my-1" wire:model.blur="field_show">
                    @endif


                </div>




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
                            wire:confirm="آیا از حذف زمینه ی ({{$field->name}}) و تمام دسته هایش مطمئن هستید؟" wire:click="deleteField({{$field->id}})"></i></div>

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

                <div class="col-xl-3"></div>

                <div class="col-xl-4">
                    <label for="category_name" class="form-label">نام دسته</label>
                    <input type="text" id="category_name" class="form-control" wire:model.blur="category_name">
                    @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                @if($editingCategory)
                    <div class="col-xl-1 py-1">
                        <button type="submit" class="btn btn-secondary mt-4"> ثبت </button>
                    </div>

                    <div class="col-xl-3 py-1">
                        <button type="button" class="btn btn-danger h-auto col-xl-2 mt-4" wire:click="cancelCategory"> <i class="btn-close"></i> </button>
                    </div>

                @else

                    <div class="col-xl-1 text-center py-1">
                        <button type="submit" class="btn btn-secondary mt-4"> ثبت </button>
                    </div>

                    <div class="col-xl-3"></div>
                @endif

            </form>



            <div class="row text-center border-top mt-5 px-3 pt-5">

                @if($categories->isNotEmpty())
                    @foreach($categories as $category)



                        <div class="col-xl-3 px-4 mx-auto">

                            <div class="row border rounded mt-3 {{$categoryActive == $category->id ? 'bg-success text-light' : ''}} ">

                                <div class="field col-xl-7 py-1 text-end text-nowrap"
                                     wire:click="selectCategory({{$category->id}})">
                                    {{$category->name}}
                                </div>

                                <div class="col-xl-2 mt-2"><i class="bi-trash-fill"
                                wire:confirm="آیا از حذف دسته ({{$category->name}}) و زیردسته هایش مطمئن هستید؟" wire:click="deleteCategory({{$category->id}})"></i></div>


                                <div class="col-xl-2 mt-2"> <i class="bi-pen-fill" wire:click="editCategory({{$category->id}})"></i></div>

                            </div>
                        </div>

                    @endforeach

                @else
                    <h3 class="text-warning mt-5"> هیچ دسته ای ثبت نشده است </h3>
                @endif

            </div>
        </div>
    </div>

    </div>

    <div class="row card mt-5">
        <div class="card-header">  <h4>شاخه ها</h4> </div>

        <div class="card-body">

            <form wire:submit.prevent="saveChild" class="row pt-5">

                @csrf

                <div class="col-xl-3"></div>

                <div class="col-xl-1 text-start"><label for="child_name" class="form-label my-2">نام شاخه</label></div>

                <div class="col-xl-3 px-2">
                    <input type="text" id="child_name" class="form-control" wire:model.blur="child_name">
                    @error('child_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-xl-2">
                    <button type="submit" class="btn btn-secondary">ثبت</button>

                   @if($editingChild)
                    <button type="submit" class="btn btn-danger w-auto" wire:click.prevent="cancelChild">انصراف</button>
                   @endif
                </div>
                <div class="col-xl-3"></div>

            </form>


            <div class="row border my-5 mx-2 rounded-4 py-3">

                @if($childs->isNotEmpty())

                    @foreach($childs as $child)

                        @if(strlen($child->name) > 35)

                        <div class="col-xl-4 px-5 mx-auto">

                            <div class="row text-nowrap border rounded-4 py-2 my-3 cs-navbar">
                                <div class="col-xl-8"> {{$child->name}} </div>

                                <div class="col-xl-1"></div>

                                <div class="col-xl-1 text-start">
                                    <i class="bi-trash-fill" wire:click="deleteChild({{$child->id}})" wire:confirm="آیا از حذف ({{$child->name}}) مطمئن هستید؟"></i>
                                </div>

                                <div class="col-xl-1 text-start mx-auto">
                                    <i class="bi-pen-fill" wire:click="editChild({{$child->id}})"></i>
                                </div>
                            </div>

                        </div>

                        @else
                            <div class="col-xl-3 px-5 mx-auto">

                                <div class="row text-nowrap border rounded-4 py-2 my-3 cs-navbar">

                                    <div class="col-xl-8"> {{$child->name}} </div>

                                    <div class="col-xl-1 text-start">
                                        <i class="bi-trash-fill" wire:click="deleteChild({{$child->id}})" wire:confirm="آیا از حذف ({{$child->name}}) مطمئن هستید؟"></i>
                                    </div>

                                    <div class="col-xl-1 text-end mx-auto">
                                        <i class="bi-pen-fill" wire:click="editChild({{$child->id}})"></i>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach

                @else
                    <div class="row text-center p-3"><h4 class="text-warning mt-1">زیردسته و شاخه ای در این دسته بندی موجود نیست</h4></div>
                @endif

            </div>


        </div>
    </div>

</div>

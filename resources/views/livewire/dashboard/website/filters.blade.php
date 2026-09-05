<div class="container">

    <div class="row text-center mt-4"><h2> فیلترها </h2></div>

    <form wire:submit.prevent="save" class="row border rounded-4 py-2">

        <div class="col-xl-1 my-auto"><label for="title">عنوان فیلتر</label></div>
        <div class="col-xl-3 my-auto">
            <input type="text" id="title" class="form-control" wire:model.blur="title" autocomplete="off">
            @error('title') <small class="text-danger"> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-2 my-auto">
            <select class="form-select" wire:model.live="field_id">

                <option value="">انتخاب موضوع</option>

                @if($this->Fields->isNotEmpty())

                    @foreach($this->Fields as $field)
                    <option value="{{$field->id}}"> {{$field->name}} </option>
                    @endforeach

                @else
                    <option value=""> موضوعی ثبت نکردید </option>
                @endif

            </select>
            @error('field_id') <small class="text-danger"> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-2 my-auto">

            @if($field_id)
                <select class="form-select" wire:model.live="category_id">

                    <option value="">همه دسته ها</option>

                    @if($this->Categories->isNotEmpty())

                        @foreach($this->Categories as $category)

                            @if($category->children->isNotEmpty())

                                <optgroup label="{{$category->name}}">
                                    @foreach($category->children as $child)

                                    <option value="{{$child->id}}">{{$child->name}}</option>

                                    @endforeach
                                </optgroup>

                            @else
                                <option value="{{$category->id}}"> {{$category->name}} </option>
                            @endif



                        @endforeach

                    @else
                        <option value=""> موضوعی ثبت نکردید </option>
                    @endif

                </select>
            @else
                <select class="form-select" wire:model.blur="category_id" disabled>

                    <option value="">انتخاب دسته</option>

                </select>
            @endif


            @error('category_id') <small class="text-danger"> {{$message}} </small> @enderror

        </div>



        <div class="col-xl-4 text-start my-auto">

            @if($editing)
                <button type="button" class="btn btn-danger rounded-3 mx-2" wire:click="cancel">انصراف</button>
            @endif

            <button type="submit" class="cs-button border-0 rounded-3 py-2 px-4">ذخیره</button>

        </div>


    </form>

    @if($this->Fields->isNotEmpty())

       <div class="row text-center py-2 mt-4">
        @foreach($this->Fields as $field)

             <input type="radio" class="btn-check mx-3" id="btn-check-{{$field->id}}-outlined" wire:model.live="activeField" value="{{$field->id}}">
             <label class="btn btn-outline-secondary w-auto rounded-4 mx-auto" for="btn-check-{{$field->id}}-outlined" wire:click="selectField({{$field->id}})">
             {{$field->name}}
             </label>

        @endforeach
        </div>
            <div class="row my-2">
                <div class="col-xl-6"><input type="text" class="form-control" placeholder="جستجو..." wire:model.live="search"></div>

                <div class="col-xl-1 my-auto">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="">همه</option>
                    </select>
                </div>

                <div class="col-xl-2 my-auto">
                    <select wire:model.live="sort" class="form-select">
                        <option value="created_at">تاریخ</option>
                        <option value="title">نام</option>
                        <option value="category_id">دسته</option>
                        <option value="type">نوع</option>
                    </select>
                </div>


                <div class="col-xl-2 my-auto">
                    <select wire:model.live="direction" class="form-select">
                        <option value="desc">نزولی</option>
                        <option value="asc">صعودی</option>
                    </select>
                </div>
            </div>

        @if($this->Filters->isNotEmpty())

            <div class="cs-navbar row text-center py-2 mt-4 mb-2 border rounded-4">

                <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selectAll"></div>



                    @if(count($showed) == count($this->Filters))
                        <div class="col-xl-1 my-auto">
                            <label for="show"> نمایش همه </label>
                            <input type="checkbox" id="show" wire:change="showNone" checked>
                        </div>
                    @else
                        <div class="col-xl-1 my-auto">
                            <label for="show"> نمایش ({{count($showed) .'/'. count($this->Filters)}}) </label>
                            <input type="checkbox" id="show" wire:change="showAll">
                        </div>
                    @endif


                <div class="col-xl-1 my-auto">ردیف</div>
                <div class="col-xl-3 my-auto">عنوان</div>
                <div class="col-xl-3 my-auto">دسته</div>
                <div class="col-xl-1 my-auto">مقادیر</div>

                <div class="col-xl-1 my-auto">

                    @if(count($selected) > 1)
                        <button class="btn btn-sm btn-danger rounded-3" wire:click="selectiveDelete"
                        wire:confirm="آیا از حذف فیلترهای انتخاب شده مطمئن هستید؟">
                            حذف همه
                        </button>
                    @else
                        حذف
                    @endif

                </div>

                <div class="col-xl-1 my-auto">ویرایش</div>

            </div>

                @foreach($this->Filters as $filter)
                <div class="row text-center py-2 my-3 border rounded-4">

                    <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selected" value="{{$filter->id}}"></div>
                    <div class="col-xl-1 my-auto"><input type="checkbox" wire:change="toggleShow({{$filter->id}})" @checked($filter->show == true)></div>
                    <div class="col-xl-1 my-auto">{{$counter++}}</div>
                    <div class="col-xl-3 my-auto">{{$filter->title}}</div>
                    <div class="col-xl-3 my-auto">{{$filter->category->name ?? 'عمومی'}}</div>

                    <div class="col-xl-1 my-auto">
                        <a href="{{route('options',$filter->id)}}" class="text-decoration-none">
                        <button class="btn btn-sm btn-link text-success fw-bolder rounded-3" wire:click="showModal({{$filter->id}})"> مشاهده </button>
                        </a>
                    </div>

                    <div class="col-xl-1 my-auto">
                        <button class="btn btn-sm btn-danger rounded-3" wire:click="delete({{$filter->id}})" wire:confirm="آیا از حذف فیلتر ({{$filter->title}}) مطمئن هستید؟">
                            حذف
                        </button>
                    </div>

                    <div class="col-xl-1 my-auto"><button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$filter->id}})"> ویرایش </button></div>

                </div>

                    @include('modals.see-filters')
                @endforeach

        @else
            <div class="row text-center py-2 mt-4 border rounded-4"> <h3 class="text-danger my-auto"> فیلتری در این زمینه ثبت نکرده اید </h3> </div>
        @endif

    @else
        <div class="row text-center py-2 mt-4 border rounded-4"> <h3 class="text-danger"> موضوعی ثبت نکرده اید </h3> </div>
    @endif

    @if($perPage !== "")
    {{$this->Filters->links(data:['scrollTo',false])}}
    @endif

</div>

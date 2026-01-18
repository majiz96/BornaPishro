<div class="container-fluid mt-4">

    <div class="row text-center"><h2>مدیریت محصولات</h2></div>

    <form wire:submit.prevent="saveProduct" enctype="multipart/form-data" class="row border rounded-4 py-3 mt-4">

        <div class="col-xl-2 my-auto">
            <label for="name" class="form-label">
                نام
            </label>

            <input type="text" id="name" class="form-control" wire:model.blur="name">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-3 my-auto">
            <label for="fullname" class="form-label">
                نام کامل
            </label>
            <input type="text" id="fullname" class="form-control" wire:model.blur="fullname">
        </div>

        <div class="col-xl-1 my-auto">
            <label for="category" class="form-label">
                دسته محصول
            </label>
            <select id="category" class="form-select" wire:model.blur="category_id">
                @if($categories->isNotEmpty())
                <option> ... </option>
                    @foreach($categories as $category)
                        @if($category->children->isNotEmpty())

                            <option value="{{$category->id}}"> {{$category->name}} </option>

                            <optgroup label="">

                                @foreach($category->children as $child)
                                    <option value="{{$child->id}}"> {{$child->name}} </option>
                                @endforeach

                            </optgroup>

                        @else
                            <option value="{{$category->id}}"> {{$category->name}} </option>
                        @endif

                    @endforeach
                @else
                    <option> دسته ای ثبت نشده است </option>
                @endif
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-1 my-auto">
            <label for="brand" class="form-label">
                انتخاب برند
            </label>
            <select id="brand" class="form-select" wire:model.blur="brand_id">
                @if($brands->isNotEmpty())
                    <option> ... </option>
                    @foreach($brands as $brand)
                        <option value="{{$brand->id}}">
                            {{$brand->name}}
                        </option>
                    @endforeach
                @else
                    <option> برندی ثبت نشده است </option>
                @endif
            </select>
        </div>

        <div class="col-xl-2 my-auto">
            <label for="brand_name" class="form-label">
                نام برند
            </label>
            <input type="text" id="brand_name" class="form-control" wire:model.blur="brand_name">

        </div>

        <div class="col-xl-1 my-auto mt-2 bo">

            <label for="image" class="btn btn-primary my-auto mt-4">
                عکس اصلی محصول
            </label>

            <input type="file" id="image" class="d-none" wire:model.blur="image">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-2 my-auto">

            @if($image)
                @if(is_string($image) && $editing)
                    <img src="{{asset('storage/products/'.$image) }}"  alt="پیش نمایش" height="100" class="rounded">
                @else
                    <img src="{{$image->temporaryUrl()}}"  alt="پیش نمایش"  height="100" class="rounded">
                @endif
            @endif

        </div>

        <div class="col-xl-12 my-3">
            <label for="intro" class="form-label">
                معرفی
            </label>

            <textarea class="form-control" rows="2" wire:model.blur="intro"></textarea>
        </div>

        <div class="row">

            <button type="submit" class="cs-button border-0 rounded-4 py-2 px-3 w-auto mx-auto"> ذخیره </button>

            @if($editing)
                <button class="btn btn-danger rounded-3 w-auto mx-auto" wire:click.prevent="cancel"> انصراف </button>
            @endif

        </div>

    </form>


    {{--- showing submitted products ---}}

    @if($products->isNotEmpty())

        <div class="row border rounded-3 mt-5 py-2">

            <div class="col-xl-1 my-auto text-center"> <input type="checkbox" wire:model.live="selectAll"> </div>
            <div class="col-xl-1 my-auto text-center"> ردیف </div>
            <div class="col-xl-1 my-auto text-center"> تصویر </div>
            <div class="col-xl-1 my-auto text-center"> نام </div>
            <div class="col-xl-3 my-auto text-center"> نام کامل </div>
            <div class="col-xl-1 my-auto text-center"> دسته </div>
            <div class="col-xl-1 my-auto text-center"> برند </div>
            <div class="col-xl-1 my-auto text-center"> پیوست ها </div>

            <div class="col-xl-1 my-auto text-center">
                @if(count($selected)>1)
                    <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف برند همه برندها مطمئن هستید؟">
                        حذف انتخابی
                    </button>
                @else
                    حذف
                @endif
            </div>

            <div class="col-xl-1 my-auto text-center"> ویرایش </div>

        </div>

    @foreach($products as $product)

            <div class="row border rounded-3 mt-3 py-2">
                <div class="col-xl-1 my-auto text-center"> <input type="checkbox" value="{{$product->id}}" wire:model.live="selected"> </div>
                <div class="col-xl-1 my-auto text-center"> {{$counter++}} </div>
                <div class="col-xl-1 my-auto text-center"> <img src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش" height="100" class="rounded"> </div>
                <div class="col-xl-1 my-auto text-center"> {{$product->name}} </div>
                <div class="col-xl-3 my-auto text-center"> {{$product->fullname}} </div>

                <div class="col-xl-1 my-auto text-center">

                    @if($product->category->parent_id == 0)

                        {{$product->category->name}}

                    @else
                        {{ $product->category->parent->name}}
                        {{$product->category->name}}

                    @endif



                </div>

                <div class="col-xl-1 my-auto text-center"> {{$product->brand->name ?? $product->brand_name ?? 'فاقد برند'}} </div>

                <div class="col-xl-1 my-auto text-center">
                    <!-- Example single danger button -->
                    <div class="btn-group me-0 text-center">

                        <button type="button" class="btn btn-secondary dropdown-toggle text-light" id="dropdownOptions" data-bs-toggle="dropdown" aria-expanded="false">
                            پیوست ها
                        </button>

                        <ul class="dropdown-menu text-end" aria-labelledby="dropdownOptions">
                            <li><a href="{{route('galleries.show',$product->id)}}" class="dropdown-item" wire:navigate> گالری </a></li>
                            <li><a href="{{route('videos.show',$product->id)}}" class="dropdown-item" wire:navigate> ویدیوها </a></li>
                            <li><a href="{{route('files.show', $product->id)}}" class="dropdown-item" wire:navigate> فایل ها </a></li>
                            <li><a href="{{route('sources.show',$product->id)}}" class="dropdown-item" wire:navigate> منابع </a></li>
                            <li><a href="{{route('briefs.show',$product->id)}}" class="dropdown-item" wire:navigate> خلاصه ها </a></li>
                            <li><a href="{{route('specifications.show',$product->id)}}" class="dropdown-item" wire:navigate> مشخصات </a></li>
                            <li><a href="{{route('comments.show',$product->id)}}" class="dropdown-item" wire:navigate> کامنت ها </a></li>

                        </ul>

                    </div>
                </div>

                <div class="col-xl-1 my-auto text-center">
                    <button class="btn btn-sm btn-danger rounded-3"
                    wire:click="delete({{$product->id}})" wire:confirm="آیا از حذف برند ({{$product->name}}) مطمئن هستید؟">
                        حذف
                    </button>
                </div>

                <div class="col-xl-1 my-auto text-center"> <button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$product->id}})">ویرایش</button> </div>

            </div>

    @endforeach



    @else

        <div class="row border rounded-3 mt-5 text-center py-3"><h2 class="text-danger"> محصولی ثبت نشده است </h2></div>

    @endif

</div>

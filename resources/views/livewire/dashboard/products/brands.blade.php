<div class="container">
    <div class="row text-center mt-4"> <h1>برندها</h1> </div>

    <form wire:submit.prevent="save" enctype="multipart/form-data">

    <div class="row border rounded-4 py-1 text-center">

        <div class="row">

            <div class="col-xl-4 py-4 my-auto">
                <div class="row">
                    <div class="col-xl-1 pt-1 text-center"><label for="name" class="form-label">نام</label></div>
                    <div class="col-xl-11"><input type="text" class="form-control" id="name" wire:model.blur="name"></div>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-xl-1 my-auto text-center">
                <label for="logo" class="btn btn-primary px-2 rounded-3 form-label my-auto">نماد برند</label>
                <input type="file" class="d-none" id="logo" wire:model.live="logo">
                @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-xl-1 my-auto text-center">
                @if($logo)
                    @if(is_string($logo) && $editing)
                        <img src="{{asset('storage/brand_logos/'.$logo) }}"  alt="پیش نمایش" height="100" class="rounded">
                    @else
                        <img src="{{$logo->temporaryUrl()}}"  alt="پیش نمایش"  height="100" class="rounded">
                    @endif
                @endif
            </div>

            <div class="col-xl-2 py-4 my-auto text-center">
                <label for="cover" class="btn btn-success px-4 rounded-3 form-label my-auto">نماد عریض برند</label>
                <input type="file" class="d-none" id="cover" wire:model.live="cover">
                @error('cover') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-xl-4 my-auto text-center overflow-hidden px-0">
                @if($cover)
                    @if(is_string($cover) && $editing)
                        <img src="{{asset('storage/brand_covers/'.$cover) }}" alt="پیش نمایش" width="350" class="rounded">
                    @else
                        <img src="{{$cover->temporaryUrl()}}" alt="پیش نمایش" width="350" class="rounded">
                    @endif
                @endif
            </div>

        </div>

        <div class="row text-center align-content-center mx-auto p-2 w-100">
            <textarea class="form-control mx-auto" rows="3" wire:model.blur="description"></textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row py-3">

            @if($editing)
                <button type="button" class="btn btn-danger rounded-3 w-auto px-4 py-2 mx-auto" wire:click="cancel"> <strong>لغو</strong> </button>
            @endif


                <button type="submit" class="cs-button border-0 rounded-3 w-auto px-4 py-2 mx-auto"> <strong>ذخیره</strong> </button>
        </div>

    </div>

    </form>

    {{--    showing brands     --}}

    @if($this->Brands->isNotEmpty())

        <div class="row mt-4">

            <div class="col-xl-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="جستجو" autocomplete="off">
            </div>

            <div class="col-xl-1">
                <select wire:model.live="perPage" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="">همه</option>
                </select>
            </div>

            <div class="col-xl-2">
                <select wire:model.live="sort" class="form-select">
                    <option value="created_at">تاریخ ایجاد</option>
                    <option value="name">نام</option>
                </select>
            </div>

            <div class="col-xl-2 my-auto">
                <select class="form-select" wire:model.live="direction">
                    <option value="desc">نزولی</option>
                    <option value="asc">صعودی</option>
                </select>
            </div>

        </div>

        <div class="row border-bottom pb-3 my-5">
            <div class="col-xl-1 text-center"><input type="checkbox" wire:model.live="selectAll"></div>
            <div class="col-xl-1 text-center">ردیف</div>
            <div class="col-xl-3 text-center">نام</div>
            <div class="col-xl-2 text-center">نماد</div>
            <div class="col-xl-3 text-center">نماد عریض</div>

            <div class="col-xl-1 text-center">
                @if(count($selected)>1)
                    <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف برند همه برندها مطمئن هستید؟">
                        حذف انتخابی
                    </button>
                @else
                    حذف
                @endif
            </div>

            <div class="col-xl-1 text-center">ویرایش</div>
        </div>

        @foreach($this->Brands as $brand)

        <div class="row py-1 border rounded-4 my-3">
            <div class="col-xl-1 text-center my-auto"><input type="checkbox" value="{{$brand->id}}" wire:model.live="selected" ></div>
            <div class="col-xl-1 text-center my-auto">{{$counter++}}</div>
            <div class="col-xl-3 text-center my-auto">{{$brand->name}}</div>

            <div class="col-xl-2 text-center my-auto">
                @if($brand->logo)
                <img src="{{asset('storage/brand_logos/'.$brand->logo) }}" alt=" نماد {{$name}} " height="50" class="rounded">
                @else
                    <h5> فاقد نماد </h5>
                @endif
            </div>

            <div class="col-xl-3 text-center my-auto">
                @if($brand->cover)
                <img src="{{asset('storage/brand_covers/'.$brand->cover) }}" alt=" نماد {{$name}} " height="50" class="rounded">
                @else
                    <h5> فاقد نماد عریض </h5>
                @endif
            </div>


            <div class="col-xl-1 text-center my-auto">
                <button class="btn btn-sm btn-danger rounded-3"
                wire:click="delete({{$brand->id}})" wire:confirm="آیا از حذف برند ({{$brand->name}}) مطمئن هستید؟">
                    حذف
                </button>
            </div>

            <div class="col-xl-1 text-center my-auto"><button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$brand->id}})">ویرایش</button></div>
        </div>

        @endforeach


    @else
        <div class="row py-3 border rounded-4 mt-5 text-danger text-center"><h3 class="my-auto"> برندی ثبت نشده است  </h3></div>
    @endif

    @if($perPage !== "")
        {{$this->Brands->links(data:['scrollTo',false])}}
    @endif



</div>

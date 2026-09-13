<div class="container">

    <div class="row text-center">
        <h1>{{$product->name}}</h1>
    </div>

    <div class="row">

    <div class="col-xl-4 side-img text-center mx-auto overflow-hidden">

      <img class="mx-auto mt-4 rounded-5" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">

    </div>

    <div class="col-xl-8 text-center mx-auto">

    <form wire:submit.prevent="save" class="row mt-4 border rounded-5 py-2 text-center mx-auto">

        <div class="row mx-auto mt-2">
            <label for="title" class="form-label text-xl-end">عنوان</label>
            <input type="text" id="title" class="form-control" wire:model.blur="title">
            @error('title') <smal class="text-danger"> {{$message}} </smal>  @enderror
        </div>

        <div class="row mx-auto mt-2">
            <label for="webname" class="form-label text-xl-end"> نام منبع </label>
            <input type="text" id="webname" class="form-control" wire:model.blur="webname">
            @error('webname') <smal class="text-danger"> {{$message}} </smal>  @enderror
        </div>

        <div class="row mx-auto mt-2">
            <label for="url" class="form-label text-xl-end">لینک</label>
            <input type="text" id="url" class="form-control" wire:model.blur="url">
            @error('url') <smal class="text-danger"> {{$message}} </smal>  @enderror
        </div>

        <div class="row mx-auto mt-3 mb-1">

            @if($editing)
                <button type="button" class="btn btn-danger rounded-4 mx-auto w-auto" wire:click="cancel"> انصراف </button>
            @endif

            <button type="submit" class="cs-button border-0 py-2 px-4 rounded-4 mx-auto w-auto"> ذخیره </button>
        </div>

    </form>

    </div>

    </div>

    {{--  Show files of this product  --}}

    @if($this->Sources->isNotEmpty())

        <div class="row mt-3 border-bottom py-3 text-center">

            <div class="col-xl-1"><input type="checkbox" wire:model.live="selectAll"></div>

            <div class="col-xl-1 text-center">ردیف</div>

            <div class="col-xl-3 text-center">عنوان</div>

            <div class="col-xl-2 text-center">منبع</div>

            <div class="col-xl-3 text-center">لینک</div>

            <div class="col-xl-1">
                @if(count($selected)>1)
                    <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف ویدیوهای انتخاب شده مطمئن هستید؟">
                        حذف انتخابی
                    </button>
                @else
                    حذف
                @endif
            </div>

            <div class="col-xl-1 text-end"> ویرایش </div>
        </div>

        @foreach($this->Sources as $source)

            <div class="row mt-3 border rounded-4 py-3 text-center">

                <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selected" value="{{$source->id}}"></div>

                <div class="col-xl-1 my-auto">{{$counter++}}</div>

                <div class="col-xl-3 my-auto overflow-hidden text-nowrap">{{$source->title}}</div>

                <div class="col-xl-2 my-auto overflow-hidden text-nowrap">{{$source->webname}}</div>

                <div class="col-xl-3 my-auto overflow-hidden text-nowrap">{{$source->url}}</div>

                <div class="col-xl-1 my-auto">
                    <button class="btn btn-sm btn-danger rounded-3"
                            wire:click="delete({{$source->id}})" wire:confirm="آیا از حذف فایل ({{$source->file}}) مطمئن هستید؟">
                        حذف
                    </button>
                </div>

                <div class="col-xl-1 my-auto text-end"><button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$source->id}})">ویرایش</button></div>



            </div>
        @endforeach


    @else
        <div class="row mt-3 border rounded-4 py-3 text-center"><h3 class="text-danger my-auto"> منبعی برای این محصول ثبت نشده است </h3></div>
    @endif

</div>

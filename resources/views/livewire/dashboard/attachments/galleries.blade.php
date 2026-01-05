<div class="container">


    <div class="row text-center mx-auto">
        <div class="col-xl-5 my-auto"></div>
        <img class="col-xl-2 mx-auto social-icon rounded p-2" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">
        <div class="col-xl-5"></div>
    </div>

    <div class="row text-center my-2"><h1>{{$products->name}}</h1></div>


    <form enctype="multipart/form-data" class="row text-center mx-auto mt-3 py-3 border rounded-4" wire:submit.prevent="save">

        <div class="col-xl-1 my-auto text-end">
            <label for="image" class="btn btn-primary"> <i class="bi-upload"></i> </label>
            <input type="file" class="d-none" id="image" wire:model.live="images" multiple>
        </div>

        <div class="col-xl-10 my-auto">
            <label class="alert alert-secondary py-2 my-auto">
                @if (count($uplaods))
                    @foreach ($uplaods as $image)
                        <img src="{{$image}}"  alt="پیش نمایش" width="64" height="64" class="mx-3 rounded">
                    @endforeach
                @else
                    {{ $uploadTip }}
                @endif
            </label>
        </div>

        <div class="col-xl-1 my-auto text-xl-start">

            <button type="submit" class="cs-button ms-0 w-auto rounded-3 border-0 py-2 px-3"> ذخیره </button>

        </div>

    </form>

    {{--  Show files of this product  --}}


    @if($galleries->isNotEmpty())

        <div class="row mt-3 border-bottom py-3 text-center">
            <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selectAll"></div>

            <div class="col-xl-1">


                @if(count($imagesShow) == count($galleries))
                    <label for="show">نمایش همه </label>
                    <input type="checkbox" id="show" class="mx-3" wire:change="showNone" checked>
                @else
                    <label for="show"> {{count($imagesShow)}} عکس </label>
                    <input type="checkbox" id="show" class="mx-3" wire:change="showAll">
                @endif

            </div>

            <div class="col-xl-1 text-center">ردیف</div>
            <div class="col-xl-2 text-center">تصویر</div>
            <div class="col-xl-2 text-center">ترتیب نمایش</div>

            <div class="col-xl-4 text-center"></div>

            <div class="col-xl-1">

                @if(count($selected)>1)
                    <button class="btn btn-sm btn-danger rounded-3" wire:change="deleteSelected" wire:confirm="آیا از حذف برند همه برندها مطمئن هستید؟">
                        حذف انتخابی
                    </button>
                @else
                    حذف
                @endif

            </div>
        </div>

        @foreach($galleries as $image)

            <div class="row mt-3 border rounded-4 py-3 text-center">

                <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selected" value="{{$image->id}}"></div>

                <div class="col-xl-1 my-auto">
                    <input type="checkbox" wire:change="toggleShow({{$image->id}})" @checked($image->show == 1)>
                </div>

                <div class="col-xl-1 my-auto">{{$counter++}}</div>

                <div class="col-xl-2 my-auto text-center">
                    <img src="{{ asset('storage/gallery/'.$image->image) }}" width="96" class="p-1 social-icon rounded">
                </div>

                <div class="col-xl-2 my-auto">

                    <span wire:click="orderUp({{$image->id}})" class="text-success mx-3 fs-4"> <i class="bi-caret-up-fill mt-2"></i> </span>
                    {{$image->order}}
                    <span wire:click="orderDown({{$image->id}})" class="text-danger mx-3 fs-4"> <i class="bi-caret-down-fill mt-2"></i> </span>

                </div>

                <div class="col-xl-4"></div>

                <div class="col-xl-1 my-auto">
                    <button class="btn btn-sm btn-danger rounded-3"
                            wire:click="delete({{$image->id}})" wire:confirm="آیا از حذف فایل این تصویر مطمئن هستید؟">
                        حذف
                    </button>
                </div>



            </div>
        @endforeach


    @else
        <div class="row mt-3 border rounded-4 py-3 text-center"><h3 class="text-danger my-auto"> تصویری برای این محصول ثبت نشده است </h3></div>
    @endif


</div>

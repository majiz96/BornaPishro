<div class="container">


    <div class="row text-center mx-auto">
        <div class="col-xl-5 my-auto"></div>
        <img class="col-xl-2 mx-auto" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">
        <div class="col-xl-5"></div>
    </div>

    <div class="row text-center my-2"><h1>{{$product->name}}</h1></div>


    <form enctype="multipart/form-data" class="row text-center mx-auto mt-3 py-3 border rounded-4" wire:submit.prevent="save">

        <div class="col-xl-1 my-auto text-end">
            <label for="file" class="btn btn-primary"> <i class="bi-upload"></i> </label>
            <input type="file" class="d-none" id="file" wire:model.live="files" multiple>
        </div>

        <div class="col-xl-10 my-auto">
            <label class="alert alert-secondary py-2 my-auto">
                @if (count($uploadedFiles))
                    @foreach ($uploadedFiles as $file)
                        <span class="badge bg-secondary me-1 m-2">{{ $file }}</span>
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

    @if($this->ProductFiles->isNotEmpty())

    <div class="row mt-3 border-bottom py-3 text-center">
        <div class="col-xl-1"><input type="checkbox" wire:model.live="selectAll"></div>
        <div class="col-xl-1">ردیف</div>
        <div class="col-xl-9 text-end pe-5">فایل</div>
        <div class="col-xl-1">

            @if(count($selected)>1)
                <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف برند همه برندها مطمئن هستید؟">
                    حذف انتخابی
                </button>
            @else
                حذف
            @endif

        </div>
    </div>

        @foreach($this->ProductFiles as $file)

            <div class="row mt-3 border rounded-4 py-3 text-center">

                <div class="col-xl-1"><input type="checkbox" wire:model.live="selected" value="{{$file->id}}"></div>
                <div class="col-xl-1">{{$counter++}}</div>

                <div class="col-xl-9">

                    @if($editing == $file->id)

                        <form wire:submit.prevent="rename">
                            <input type="text" class="rounded w-75 border-0 pe-2 py-2" wire:model.blur="name">

                            <button class="btn btn-danger text-center py-0 px-1 mx-2" wire:click="$set('editing',null)">
                                <i class="bi-x my-auto mx-auto"></i>
                            </button>

                            <button type="submit" class="btn btn-success text-center py-0 px-1 ">
                                <i class="bi-check my-auto mx-auto"></i>
                            </button>
                        </form>

                    @else
                        <div class="row">

                        <div class="col me-0 text-nowrap text-end">{{$file->file}}</div>

                        <div class="col ms-0 text-start">
                            <button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$file->id}})"> تغییر نام </button>
                        </div>

                        </div>
                    @endif


                </div>


                    <div class="col-xl-1">
                        <button class="btn btn-sm btn-danger rounded-3"
                                wire:click="delete({{$file->id}})" wire:confirm="آیا از حذف فایل ({{$file->file}}) مطمئن هستید؟">
                            حذف
                        </button>
                    </div>



            </div>
        @endforeach


    @else
    <div class="row mt-3 border rounded-4 py-3 text-center"><h3 class="text-danger my-auto"> فایلی برای این محصول ثبت نشده است </h3></div>
    @endif


</div>

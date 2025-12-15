<div class="container mt-4">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row text-center my-3"> <h2> مجوزهای وبسایت </h2> </div>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="row mb-3 border rounded-4 py-2">

        @csrf

        <div class="col-xl-2">
            <label class="form-label">نام</label>
            <input type="text" wire:model.blur="name" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-4">
            <label class="form-label">لینک</label>
            <input type="text" wire:model.blur="link" class="form-control">
            @error('link') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-3">
            <label class="form-label">نماد</label>
            <input type="file" wire:model.live="icon" class="form-control">
            @error('icon') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-1 text-center">
            @if($icon)
                @if(is_string($icon) && $editing)
                    <img src="{{asset('storage/social_icons/'.$icon)}}"  alt="پیش نمایش" height="50" class="mt-3">
                @else
                    <img src="{{$icon->temporaryUrl()}}"  alt="پیش نمایش" width="50" height="50" class="mt-3">
                @endif
            @endif
        </div>

        <div class="col-xl-2">
            <label class="form-label">تاریخ انقضاء</label>
            <input type="text" class="form-control" wire:model.blur="expire" placeholder="1404/xx/xx">
            @error('expire') <small class="text-danger">{{ $message }}</small> @enderror
        </div>


        <div class="col-xl-12 mt-3">
            <label class="form-label">توضیحات</label>
            <textarea class="form-control" rows="2" wire:model.blur="description"></textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-12 mt-2">
            @if($editing)
                <button type="submit" class="cs-button border-0 rounded-3 w-auto py-2 px-4">ذخیره</button>
                <br>
                <button type="button" class="btn btn-outline-danger rounded-3 w-auto py-1 px-3" wire:click="cancel">انصراف</button>
            @else
                <button type="submit" class="cs-button ms-0 border-0 rounded-3 w-auto py-2 px-4 my-1">ذخیره</button>
            @endif
        </div>

    </form>

    @if($licenses->isNotEmpty())

            <div class="row mx-auto py-2 px-0 mx-3">

                @foreach($licenses as $license)

                    {{-- کارت مجوز --}}
                    <div class="col-xl-5 card my-2 rounded-4 mx-auto">

                        <div class="card-header row rounded-top-4">


                            <div class="col-xl-4"> {{$license->name}} </div>
                            <div class="col-xl-4"></div>
                            <div class="col-xl-4 text-start">انقضاء : {{$license->expire}}</div>


                        </div>

                        <div class="card-body row">
                            <div class="col-xl-3 border border-danger">
                                <img src="{{ asset('storage/license_icons/'.$license->icon) }}" class="social-icon mb-3 p-1 rounded" height="50">
                            </div>

                            <div class="col-xl-9 border border-warning">
                               {{$license->description}}
                            </div>

                            <div class="col-xl-12 mt-2">
                                لینک :
                                <a href="{{$license->link}}"> {{$license->link}} </a>
                            </div>

                        </div>

                        <div class="card-footer row p-2">

                            <div class="col-xl-3">
                                <label class="form-label my-1">فعال</label>
                                <input type="checkbox" name="" id="" class="mx-2 mt-3" checked>
                            </div>

                            <div class="col-xl-3">
                                <label class="form-label my-1">نمایش</label>
                                <input type="checkbox" name="" id="" class="mx-2 mt-3">
                            </div>

                            <div class="col-xl-2"></div>

                            <div class="col-xl-2 text-center">
                                <button class="btn btn-sm btn-danger mt-1 rounded-3" wire:click="delete()" wire:confirm="آیا از حذف ((  )) مطمئن هستید؟">حذف</button>
                            </div>

                            <div class="col-xl-2 text-center">
                                <button class="btn btn-sm btn-primary mt-1 rounded-3" wire:click="edit()">ویرایش</button>
                            </div>

                        </div>

                    </div>

                @endforeach






            </div>

    @else
            <div class="row text-center mt-5">
                <h3 class="text-warning"> هیچ مجوزی ثبت نشده است </h3>
            </div>
    @endif



</div>

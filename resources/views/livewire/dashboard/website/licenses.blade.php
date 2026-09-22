<div class="container-fluid mt-4">

    <div class="row text-center my-3"> <h2> مجوزهای وبسایت </h2> </div>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="row mb-3 border rounded-4 py-2">

        @csrf

        <div class="col-xl-2">
            <label class="form-label">نام</label>
            <input type="text" wire:model.blur="name" class="form-control">

        </div>

        <div class="col-xl-4">
            <label class="form-label">لینک</label>
            <input type="text" wire:model.blur="link" class="form-control">
            @error('link') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xxl-3 col-xl-2">
            <label class="form-label">نماد</label>
            <input type="file" wire:model.live="icon" class="form-control">
            @error('icon') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-1 text-center">
            @if($icon)
                @if(is_string($icon) && $editing)
                    <img src="{{asset('storage/license_icons/'.$icon) }}"  alt="پیش نمایش" height="64" class="mt-3">
                @else
                    <img src="{{$icon->temporaryUrl()}}"  alt="پیش نمایش" width="64" height="64" class="mt-3">
                @endif
            @endif
        </div>

        <div class="col-xl-2">
            <label class="form-label">تاریخ انقضاء</label>
            <div
                data-jalali-date-picker-wrapper
                data-value="{{ $date_picker ?? '' }}"
                wire:ignore
            ></div>

            @error('$date_picker')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <div class="col-xl-12 mt-3">
            <label class="form-label">توضیحات</label>
            <textarea class="form-control" rows="2" wire:model.blur="description"></textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-12 mt-2">

            @if($editing)
                <button type="submit" class="btn btn-success border-0 rounded-3 w-auto py-2 px-4">ذخیره</button>

                <button type="button" class="btn btn-outline-danger rounded-3 w-auto py-2 px-3 mx-2" wire:click="cancel">انصراف</button>
            @else
                <button type="submit" class="cs-button ms-0 border-0 rounded-3 w-auto py-2 px-4 my-1">ذخیره</button>
            @endif
        </div>

    </form>

    @if($this->Licenses->isNotEmpty())

            <div class="row mx-auto py-2 px-0 mx-3">

                @foreach($this->Licenses as $license)

                    {{-- کارت مجوز --}}
                    <div class="col-xxl-5 col-xl-8 card my-2 rounded-4 mx-auto">

                        <div class="card-header row rounded-top-4">


                            <div class="col-xl-4"> {{$license->name}} </div>
                            <div class="col-xl-4"></div>
                            <div class="col-xl-4 text-start">انقضاء : {{$model::first()->fromJalaliDatePickerDiff($license->expire)}}</div>


                        </div>

                        <div class="card-body row">
                            <div class="col-xl-4">
                                <img src="{{ asset('storage/license_icons/'.$license->icon) }}" width="128" class="p-1 social-icon rounded">
                            </div>

                            <div class="col-xl-8">
                               {{$license->description}}
                            </div>

                            <div class="col-xl-12 mt-2">
                                لینک :
                                <a href="{{$license->link}}" target="_blank"> {{$license->link}} </a>
                            </div>

                        </div>

                        <div class="card-footer row p-2">

                            <div class="col-xl-4">
                                <label class="form-label my-1">هشدار انقضاء</label>
                                <input type="checkbox" name="" id="" class="mx-2 mt-3" wire:change="toggleActive({{$license->id}})" @checked($license->active == 1)>
                            </div>

                            <div class="col-xl-3">
                                <label class="form-label my-1">نمایش</label>
                                <input type="checkbox" name="" id="" class="mx-2 mt-3"  wire:change="toggleShow({{$license->id}})" @checked($license->show == 1)>
                            </div>

                            <div class="col-xl-1"></div>

                            <div class="col-xl-2 text-center">
                                <button class="btn btn-sm btn-danger mt-1 rounded-3" wire:click="delete({{$license->id}})"
                                wire:confirm="آیا از حذف (( {{$license->name}} )) مطمئن هستید؟">حذف</button>
                            </div>

                            <div class="col-xl-2">
                                <button class="btn btn-sm btn-primary mt-1 me-xl-2 rounded-3" wire:click="edit({{$license->id}})">ویرایش</button>
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

<div class="container mt-4">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="row text-center my-5">
        <h2> تنظیم شبکه های مجازی </h2>
    </div>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="row mb-3 border rounded-4 py-2">

        @csrf

        <div class="col-xl-2">
            <label class="form-label">نام</label>
            <input type="text" wire:model.live="name" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-4">
            <label class="form-label">لینک</label>
            <input type="text" wire:model.live="link" class="form-control">
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

        <div class="col-xl-2 text-xl-start">
            @if($editing)
                <button type="submit" class="cs-button me-0 border-0 rounded-3 w-auto py-2 px-4 mt-1">ذخیره</button>
                <br>
                <button type="button" class="btn btn-outline-danger me-0 rounded-3 w-auto py-1 px-3 mt-3" wire:click="cancel">انصراف</button>
            @else
                <button type="submit" class="cs-button me-0 border-0 rounded-3 w-auto py-2 px-4 mt-4">ذخیره</button>
            @endif
        </div>

    </form>

        @if($this->Socials->isNotEmpty())


    <div class="row border rounded-4">

        <div class="col-xl-1 mx-auto text-center">
            <input type="checkbox" wire:model.live="selectAll">
            @if($selectAll || count($selected) > 1)
            <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف تمام شبکه های مجازی مطمئن هستید؟">حذف همه</button>
            @endif
        </div>


        <div class="col-xl-1 mx-auto text-center">ردیف</div>
        <div class="col-xl-1 mx-auto text-center">تصویر</div>
        <div class="col-xl-2 mx-auto text-center">نام</div>
        <div class="col-xl-4 mx-auto text-center">لینک</div>
        <div class="col-xl-1 mx-auto text-center">حذف</div>
        <div class="col-xl-1 mx-auto text-center">ویرایش</div>
    </div>


          @foreach($this->Socials as $social)
            <div class="row mt-4 border-bottom">
                <div class="col-xl-1 mx-auto text-center"><input type="checkbox" class="mt-3" wire:model.live="selected" value="{{$social->id}}"></div>
                <div class="col-xl-1 mx-auto text-center"><div class="mt-2 text-center"> {{$counter++}} </div></div>
                <div class="col-xl-1 mx-auto text-center"><img src="{{ asset('storage/social_icons/'.$social->icon) }}?v={{ $social->updated_at->timestamp}}" class="social-icon mb-3 p-1 rounded" height="50"></div>
                <div class="col-xl-2 mx-auto col-5 text-center"> <div class="mt-1"> {{$social->name}} </div> </div>
                <div class="col-xl-4 mx-auto text-center"><div class="mt-1"> <a href="" class="nav-link">{{$social->link}} </a> </div></div>

                <div class="col-xl-1 mx-auto text-center"><button class="btn btn-sm btn-danger mt-1 rounded-3" wire:click="delete({{$social->id}})" wire:confirm="آیا از حذف (( {{$social->name}} )) مطمئن هستید؟">حذف</button></div>
                <div class="col-xl-1 mx-auto text-center"><button class="btn btn-sm btn-primary mt-1 rounded-3" wire:click="edit({{$social->id}})">ویرایش</button></div>
            </div>
        @endforeach
    @else
        <div class="row text-center mt-5">
        <h3 class="text-warning"> هیچ شبکه اجتماعی ثبت نشده است </h3>
        </div>
    @endif
</div>

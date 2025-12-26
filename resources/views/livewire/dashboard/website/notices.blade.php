<div class="container my-4">
    <form wire:submit.prevent="save" class="row g-3">

        {{-- عنوان --}}
        <div class="col-md-12">
            <label for="title" class="form-label">عنوان</label>
            <input type="text" id="title" wire:model.defer="title" class="form-control" placeholder="عنوان اعلان">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- توضیحات --}}
        <div class="col-md-12">
            <label for="description" class="form-label">پیام</label>
            <textarea id="description" wire:model.defer="description" class="form-control" rows="4"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- محل نمایش --}}
        <div class="col-md-4">
            <label for="display" class="form-label">نحوه نمایش</label>
            <select id="display" wire:model.defer="display" class="form-select">
                <option value="">انتخاب کنید...</option>
                <option value="home">زیر نوبار (صفحه اصلی)</option>
                <option value="icon">اعلانات نوبار</option>
                <option value="email">ایمیل</option>
                <option value="slider">اسلایدر</option>
                <option value="tiles">کاشی‌های صفحه اصلی</option>
            </select>
            @error('display') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- مخاطبین --}}
        <div class="col-md-4">
            <label for="contact" class="form-label">مخاطبین</label>
            <select id="contact" wire:model.live="contact" class="form-select">
                <option value="">انتخاب کنید...</option>
                <option value="all">همه</option>
                <option value="users">کاربران عضو</option>
                <option value="admins">ادمین‌ها</option>
            </select>
            @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- موقعیت (فقط برای ادمین‌ها) --}}
        @if($contact === 'admins')
            <div class="col-md-4">
                <label for="position_id" class="form-label">موقعیت</label>
                <select id="position_id" wire:model.defer="position_id" class="form-select">
                    <option value="">انتخاب کنید...</option>
                    @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->title}}</option>
                    @endforeach
                </select>
                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @else
            <div class="col-md-4">
                <label for="position_id" class="form-label">جایگاه</label>
                <select id="position_id" wire:model.defer="position_id" class="form-select" disabled>
                    <option value="">انتخاب کنید...</option>
                    @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->title}}</option>
                    @endforeach
                </select>
                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- استایل --}}
        <div class="col-md-4">
            <label for="style" class="form-label">استایل</label>
            <select id="style" wire:model.defer="style" class="form-select">
                <option value="">انتخاب کنید...</option>
                <option value="primary">آبی (پرایمری)</option>
                <option value="success">سبز (ساکسس)</option>
                <option value="danger">قرمز (خطر)</option>
                <option value="warning">زرد (هشدار)</option>
                <option value="info">فیروزه‌ای (اطلاعات)</option>
            </select>
            @error('style') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

{{--        --}}{{-- وضعیت --}}
{{--        <div class="col-md-6 d-flex align-items-center">--}}
{{--            <div class="form-check mt-4">--}}
{{--                <input type="checkbox" id="status" wire:model.defer="status" class="form-check-input" value="1">--}}
{{--                <label for="status" class="form-check-label">فعال</label>--}}
{{--            </div>--}}
{{--            @error('status') <span class="text-danger">{{ $message }}</span> @enderror--}}
{{--        </div>--}}

        {{-- تاریخ انقضا (شمسی) --}}
        <div class="col-md-4">
            <label for="expired_at" class="form-label">تاریخ انقضا</label>
            <input type="text" id="expired_at" wire:model.defer="expired_at" class="form-control"
                   placeholder="مثلاً 1404/10/05">
            @error('expired_at') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- دکمه ذخیره --}}
        <div class="col-md-4 py-0">
            <div class="row mt-3 px-3"><button type="submit" class="btn btn-primary mt-3 mx-auto"> ارسال پیام </button></div>

        </div>
    </form>
</div>

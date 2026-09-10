<div class="card rounded-4">
    <div class="card-header text-center">
        <h4 class="mb-0 py-2"> اطلاعات وبسایت </h4>
    </div>

    <div class="card-body">

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

{{--            <div class="row text-center">--}}
{{--                <h1>{{ $model::first()->fromJalaliDatePicker($date_picker) }}</h1>--}}
{{--            </div>--}}

        <form wire:submit.prevent="save">

            @csrf

            <div class="row">


                <div class="col-md-3 mb-3">
                    <label class="form-label">تلفن</label>
                    <input type="text" class="form-control" wire:model="phone">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">موبایل</label>
                    <input type="text" class="form-control" wire:model="mobile">
                    @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">ایمیل</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">تاریخ شروع</label>

                    <div
                        data-jalali-date-picker-wrapper
                        data-value="{{ $date_picker ?? '' }}"
                        wire:ignore
                    ></div>

                    @error('$date_picker')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">شرایط فعالیت حضوری</label>
                    <input type="text" class="form-control" wire:model="activity">
                    @error('activity') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">شرایط پاسخگویی تلفنی</label>
                    <input type="text" class="form-control" wire:model="response">
                    @error('response') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">آدرس</label>
                    <textarea class="form-control" rows="1" wire:model="address"></textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- درباره ما (textarea با شمارشگر) -->
                <div class="col-12 mb-3">
                    <label class="form-label">درباره ما</label>
                    <textarea class="form-control" rows="5" wire:model="about_us"
                              maxlength="1000"></textarea>
                    @error('about_us') <small class="text-danger">{{ $message }}</small> @enderror

                    <!-- شمارشگر -->
                    <div class="mt-1">
                        <small
                            @if(strlen($about_us ?? '') >= 990)
                                class="text-danger"
                            @else
                                class="text-muted"
                            @endif>
                            {{ strlen($about_us ?? '') }}/1000
                        </small>
                    </div>
                </div>


            </div>

            <button class="cs-button py-2 px-4 border-0 rounded-3">ذخیره</button>

        </form>
    </div>
</div>

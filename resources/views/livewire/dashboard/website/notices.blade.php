<div class="container-fluid my-4">

    <form wire:submit.prevent="save" class="row g-3">

        {{-- عنوان --}}
        <div class="col-md-12">
            <label for="title" class="form-label">عنوان</label>
            <input type="text" id="title" wire:model.blur="title" class="form-control" placeholder="عنوان اعلان">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- توضیحات --}}
        <div class="col-md-12">
            <label for="description" class="form-label">پیام</label>
            <textarea id="description" wire:model.blur="description" class="form-control" rows="4"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- محل نمایش --}}
        <div class="col-md-4">
            <label for="display" class="form-label">نحوه نمایش</label>
            <select id="display" wire:model.live="display" class="form-select">
                <option value="">انتخاب کنید...</option>
                <option value="نماد">اعلانات نوبار</option>
                <option value="ایمیل">ایمیل</option>
                <option value="اسلایدر">اسلایدر</option>
                <option value="کاشی ها">کاشی‌های صفحه اصلی</option>
            </select>
            @error('display') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- مخاطبین --}}
        <div class="col-md-4">
            <label for="contact" class="form-label">مخاطبین</label>
            <select id="contact" wire:model.live="contact" class="form-select">

                <option value="">انتخاب کنید...</option>
                <option value="همه">همه</option>
                @if($display == 'نماد' ||$display == 'ایمیل')
                    <option value="کاربران">کاربران عضو</option>
                    <option value="ادمین ها">ادمین‌ها</option>
                @endif

            </select>
            @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- موقعیت (فقط برای ادمین‌ها) --}}
        @if($contact === 'ادمین ها')
            <div class="col-md-4">
                <label for="position_id" class="form-label">حداقل سطح</label>
                <select id="position_id" wire:model.blur="position_id" class="form-select">
                    <option value="">انتخاب کنید...</option>
                    @foreach($positions as $position)
                        @if($position->level > 0)
                        <option value="{{$position->id}}">{{$position->title}} </option>
                        @endif
                    @endforeach
                </select>
                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @else
            <div class="col-md-4">
                <label for="position_id" class="form-label">حداقل سطح</label>
                <select id="position_id" wire:model.blur="position_id" class="form-select" >
                        <option value="4"> همه </option>
                </select>
                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- استایل --}}
        <div class="col-md-4">
            <label for="style" class="form-label"> تم </label>
            <select id="style" wire:model.blur="style" class="form-select">
                <option value="">انتخاب کنید...</option>
                <option value="secondary">خاکستری</option>
                <option value="primary">آبی</option>
                <option value="info">فیروزه‌ای</option>
                <option value="success">سبز</option>
                <option value="warning">زرد</option>
                <option value="danger">قرمز</option>
            </select>
            @error('style') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- تاریخ انقضا (شمسی) --}}
        <div class="col-md-4">
            <label for="date_picker" class="form-label">تاریخ انقضا</label>

            <div
                data-jalali-date-picker-wrapper
                data-value="{{ $date_picker ?? '' }}"
                wire:ignore
            ></div>

            @error('$date_picker')
            <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        {{-- دکمه ذخیره --}}
        <div class="col-md-4 py-0">

            @if($editing)
            <div class="row mt-3 px-3">

                <button type="submit" class="btn btn-success mt-3 mx-auto w-auto"> ذخیره </button>
                <button type="button" class="btn btn-danger mt-3 mx-auto w-auto" wire:click="cancel"> انصراف  </button>

            </div>
            @else
            <div class="row mt-3 px-3"><button type="submit" class="btn btn-primary mt-3 mx-auto"> ارسال پیام </button></div>
            @endif


        </div>
    </form>


    <div class="row my-5 border rounded-4 p-2">

        <div class="row my-3 mx-auto">

            <div class="col-xl-3">
            <input type="text" class="form-control" placeholder="جستجو..." wire:model.live="search">
            </div>

            <div class="col-xl-1 my-auto">
                <select class="form-select" wire:model.live="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="">همه</option>
                </select>
            </div>

            <div class="col-xl-2 my-auto">
                <select class="form-select" wire:model.live="sort">
                    <option value="created_at">تاریخ</option>
                    <option value="title">عنوان</option>
                    <option value="display">نمایش</option>
                    <option value="contact">مخاطب</option>
                    <option value="expired_at">انقضاء</option>
                    <option value="style">تم</option>
                    <option value="status">فعال</option>
                </select>
            </div>

            <div class="col-xxl-1 col-xl-2 my-auto">
                <select class="form-select" wire:model.live="direction">
                    <option value="desc">نزولی</option>
                    <option value="asc">صعودی</option>
                </select>
            </div>

        </div>

        @if($notices->isNotEmpty())

        <div class="cs-navbar row mx-auto py-3 border rounded-3">

            <div class="col-xl-auto text-end">

                <input type="checkbox" class="mx-2" wire:model.live="selectAll">
                ردیف
            </div>

            <div class="col-xl-2 text-center">عنوان</div>
            <div class="col-xxl-1 col-xl-auto text-center"> نحوه نمایش </div>
            <div class="col-xl-1 text-center"> مخاطب </div>
            <div class="col-xl-1 text-center"> جایگاه </div>
            <div class="col-xl-1 text-center"> تم </div>
            <div class="col-xxl-2 col-xl-auto text-center"> انقضاء </div>
            <div class="col-xl-1 text-center"> فعال </div>

            <div class="col-xxl-auto col-xl-3 text-center">

                @if( count($selected) > 1)

                <button class="btn btn-sm btn-danger mt-1 rounded-2" wire:click="selectedDelete"
                wire:confirm="آیا از حذف کاربران انتخاب شده مطمئن هستید؟"> حذف همه </button>

                @endif

            </div>


            </div>




            @foreach($notices as $notice)



            <div class="row mx-auto py-2 border rounded-3 my-4 mb-1">

                <div class="col-xl-auto text-end">
                    <input class="mt-2 mx-3" type="checkbox" value="{{$notice->id}}" wire:model.live="selected">
                    {{$row++}}
                </div>

                <div class="col-xl-2 pt-1 text-center">{{$notice->title}}</div>
                <div class="col-xl-1 pt-1 text-center"> {{$notice->display}} </div>
                <div class="col-xl-1 pt-1 text-center"> {{$notice->contact}} </div>
                <div class="col-xl-1 pt-1 text-center"> {{$notice->position->title}} </div>
                <div class="col-xl-1 pt-1 text-{{$notice->style}}  text-center"> {{$notice->style}} </div>

                <div class="col-xxl-2 col-xl-auto text-center"> {{\App\Models\Notice::first()->fromJalaliDatePicker($notice->expired_at)}} </div>

                <div class="col-xl-1 text-center">
                    <input class="mt-2" type="checkbox" id="active" wire:change="toggleStatus({{$notice->id}})" @checked($notice->status == 1)>
                </div>

                <div class="col-xl-auto px-0">

                    <button class="btn btn-sm btn-success mt-1 rounded-2 ms-3" wire:click="see({{$notice->id}})"> مشاهده </button>

                    <button class="btn btn-sm btn-danger mt-1 rounded-2 mx-2" wire:click="delete({{$notice->id}})"
                    wire:confirm="آیا از حذف (( {{$notice->title}} )) مطمئن هستید؟">حذف</button>

                    <button class="btn btn-sm btn-primary mt-1 rounded-2 me-2 ms-0" wire:click="edit({{$notice->id}})"> ویرایش </button>

                </div>

            </div>

                @include('modals.see-notice')
              @endforeach

        </div>
        @else

            <div class="row mt-1 text-center text-danger"> <h3> هیچ پیامی ارسال نشده است </h3> </div>

        @endif

    @if($perPage !== "")
    {{$notices->links(data:['scrollTo',false])}}
    @endif


    </div>





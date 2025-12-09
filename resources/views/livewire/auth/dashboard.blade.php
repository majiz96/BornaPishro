<div class="container-fluid">
    @use(\Illuminate\Support\Facades\Auth)

    <div class="row text-center px-0">

        <h2> داشبورد </h2>

{{--        list of pages--}}
        <div class="col-1">

                <ul class="list-group row py-2">

                    <li class="cs-header list-group-item text-center border h-auto"> <h5>کاربری</h5> </li>

                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> ویرایش پروفایل </a></li>

                    @can('isManager')
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت دسترسی </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت کاربران </a></li>
                    @endcan

                </ul>
                @can('isAdmin') {{-- just admins have access to these categories --}}
                <ul class="list-group row py-2">

                    <li class="cs-header-web t list-group-item text-center border"> <h5>وبسایت</h5> </li>
                    @can('isManager')
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> اطلاعات وبسایت </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مشخصات وبسایت </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> اعلانات </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> درباره ما </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> صفحات مجازی </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مجوزها </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> دسته‌بندی‌ ها </a></li>
                    @endcan
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href=""> ارتباطات </a></li>

                </ul>

                @can('isAssistant'){{-- just manager & assistants have access to these categories --}}
                <ul class="list-group row py-2">

                    <li class="cs-header-product t list-group-item text-center border"> <h5>محصولات</h5> </li>

                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت محصولات </a></li>
                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت برندها </a></li>

                </ul>

                <ul class="list-group row py-2">

                    <li class="cs-header-mag t list-group-item text-center border"> <h5>مقالات</h5> </li>

                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت مقالات </a></li>

                </ul>

                <ul class="list-group row py-2">

                    <li class="cs-header-service t list-group-item text-center border"> <h5>خدمات</h5> </li>

                    <li class="list-group-item list-group-item-action text-end"><a class="nav-link" href="" wire:navigate> مدیریت خدمات </a></li>

                </ul>
            @endcan {{-- just manager & assistants have access to these categories --}}
            @endcan {{-- just admins have access to these categories --}}

        </div>

{{--        show page contents--}}
        <div class="showbox col-10 border border-secondary mx-auto rounded-4"></div>


    </div>

</div>

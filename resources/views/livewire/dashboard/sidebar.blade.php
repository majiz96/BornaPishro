{{--        list of pages--}}
<div class="col-1 d-none d-xl-inline">

    <ul class="list-group row py-2">

        <li class="cs-header-user list-group-item text-center border h-auto py-1"> <h5>کاربری</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('profile') ? 'active-page' : ''}}">
            <a class="nav-link" href="{{route('profile')}}" wire:navigate> ویرایش پروفایل </a></li>

        @can('isManager')
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('users') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('users')}}" wire:navigate> مدیریت کاربران </a></li>
        @endcan

    </ul>
    @can('isAdmin') {{-- just admins have access to these categories --}}
    <ul class="list-group row py-2">

        <li class="cs-header-web t list-group-item text-center border py-1"> <h5>وبسایت</h5> </li>
        @can('isManager')
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('info') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('info')}}" wire:navigate> اطلاعات وبسایت </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('social') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('social')}}" wire:navigate> صفحات مجازی </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('licenses') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('licenses')}}" wire:navigate> مجوزها </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('categories') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('categories')}}" wire:navigate> دسته‌بندی‌ ها </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('filters') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('filters')}}" wire:navigate> فیلترها </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('notices') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('notices')}}" wire:navigate> اعلانات </a></li>

        @endcan
        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('comms') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('comms')}}"> ارتباطات </a></li>

    </ul>

    @can('isAssistant'){{-- just manager & assistants have access to these categories --}}
    <ul class="list-group row py-2">

        <li class="cs-header-product t list-group-item text-center border py-1"> <h5>محصولات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('products-management') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('products-management')}}" wire:navigate> مدیریت محصولات </a></li>
        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('brands') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('brands')}}" wire:navigate> مدیریت برندها </a></li>

    </ul>

    <ul class="list-group row py-2">

        <li class="cs-header-mag t list-group-item text-center border py-1"> <h5>مقالات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('articles-management') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('articles-management')}}" wire:navigate> مدیریت مقالات </a></li>

    </ul>

    <ul class="list-group row py-2">

        <li class="cs-header-service t list-group-item text-center border py-1"> <h5>خدمات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('services-management') ? 'active-page' : ''}}"><a class="nav-link" href="{{route('services-management')}}" wire:navigate> مدیریت خدمات </a></li>

    </ul>
    @endcan {{-- just manager & assistants have access to these categories --}}
    @endcan {{-- just admins have access to these categories --}}

</div>

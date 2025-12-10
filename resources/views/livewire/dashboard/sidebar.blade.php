
{{--        list of pages--}}
<div class="col-1">

    <ul class="list-group row py-2">

        <li class="cs-header-user list-group-item text-center border h-auto py-1"> <h5>کاربری</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('profile') ? 'active-page-user' : ''}}">
            <a class="nav-link" href="{{route('profile')}}" wire:navigate> ویرایش پروفایل </a></li>

        @can('isManager')
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('levels') ? 'active-page-user' : ''}}"><a class="nav-link" href="{{route('levels')}}" wire:navigate> مدیریت دسترسی </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('users') ? 'active-page-user' : ''}}"><a class="nav-link" href="{{route('users')}}" wire:navigate> مدیریت کاربران </a></li>
        @endcan

    </ul>
    @can('isAdmin') {{-- just admins have access to these categories --}}
    <ul class="list-group row py-2">

        <li class="cs-header-web t list-group-item text-center border py-1"> <h5>وبسایت</h5> </li>
        @can('isManager')
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('info') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('info')}}" wire:navigate> اطلاعات وبسایت </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('notices') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('notices')}}" wire:navigate> اعلانات </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('about') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('about')}}" wire:navigate> درباره ما </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('social') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('social')}}" wire:navigate> صفحات مجازی </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('licenses') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('licenses')}}" wire:navigate> مجوزها </a></li>
            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('categories') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('categories')}}" wire:navigate> دسته‌بندی‌ ها </a></li>
        @endcan
        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('comms') ? 'active-page-web' : ''}}"><a class="nav-link" href="{{route('comms')}}"> ارتباطات </a></li>

    </ul>

    @can('isAssistant'){{-- just manager & assistants have access to these categories --}}
    <ul class="list-group row py-2">

        <li class="cs-header-product t list-group-item text-center border py-1"> <h5>محصولات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('products') ? 'active-page-product' : ''}}"><a class="nav-link" href="{{route('products')}}" wire:navigate> مدیریت محصولات </a></li>
        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('brands') ? 'active-page-product' : ''}}"><a class="nav-link" href="{{route('brands')}}" wire:navigate> مدیریت برندها </a></li>

    </ul>

    <ul class="list-group row py-2">

        <li class="cs-header-mag t list-group-item text-center border py-1"> <h5>مقالات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('articles') ? 'active-page-article' : ''}}"><a class="nav-link" href="{{route('articles')}}" wire:navigate> مدیریت مقالات </a></li>

    </ul>

    <ul class="list-group row py-2">

        <li class="cs-header-service t list-group-item text-center border py-1"> <h5>خدمات</h5> </li>

        <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('services') ? 'active-page-service' : ''}}"><a class="nav-link" href="{{route('services')}}" wire:navigate> مدیریت خدمات </a></li>

    </ul>
    @endcan {{-- just manager & assistants have access to these categories --}}
    @endcan {{-- just admins have access to these categories --}}

</div>

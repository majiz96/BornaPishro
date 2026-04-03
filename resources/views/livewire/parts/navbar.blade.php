<nav class="cs-navbar navbar navbar-expand-lg text-light m-4 py-xl-0 rounded-4 sticky-top" dir="rtl">

    <div class="container-fluid">

        <div class="w-100 d-none d-lg-flex mt-0">

            <a class="navbar-brand text-light" href="/"><h1>برناپیشرو</h1></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"></span>
            </button>


            @guest
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('login')}}" wire:navigate>ورود</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('register')}}" wire:navigate>ثبت نام</a></li>

                        <li class="nav-item"><a class="nav-link text-light">|</a></li>

                        <li class="nav-item"><a class="nav-link text-light" href="{{ route('products') }}" wire:click="toggleMenu(1)">محصولات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">خدمات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">ارتباط با ما</a></li>
                    </ul>
                </div>

            @endguest


            @auth

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="{{ route('products') }}" wire:click="toggleMenu(1)">محصولات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">خدمات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">ارتباط با ما</a></li>
                    </ul>
                </div>

                <!-- Example single danger button -->
                <div class="btn-group me-0 px-5">

                    <button type="button" class="btn dropdown-toggle text-light borderless" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        @if($name && $lastname)
                            {{$name}}  {{$lastname}}
                        @endif
                    </button>

                    <ul class="dropdown-menu text-end" aria-labelledby="dropdownUser">
                        <li><a href="{{route('profile')}}" class="dropdown-item" wire:navigate> پروفایل </a></li>
                        <li><a href="" class="dropdown-item" wire:click="logout" wire:confirm="آیابرای خروج از وبسایت مطمئن هستید؟" wire:navigate> خروج </a></li>
                    </ul>

                </div>

                <!-- Example single bell button -->
                <div class="btn-group me-0 px-4">

                    <button type="button" class="btn dropdown-toggle text-light no-caret borderless" id="dropdownBellBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-bell my-auto"></i>

                        @if(($unreadNotice ?? collect())->count()>0)
                        <sup class="bg-danger text-light rounded-5 px-1">{{ ($unreadNotice ?? collect())->count() }}</sup>
                    </button>

                    <ul aria-labelledby="dropdownBellBtn" class="dropdown-menu text-end px-2">

                        @foreach($unreadNotice as $notice)
                        <li class="mt-2">
                            <a class="dropdown-item text-{{$notice->style}} rounded" href="{{route('messages.show',$notice->id)}}" wire:navigate> {{$notice->title}} </a>
                        </li>
                        @endforeach



                    </ul>

                    @endif
                </div>

            @endauth



            <div class="me-0 px-4 my-auto">

                @if(  $theme === 'light')
                    <i class= "bi-moon" wire:click="toggleTheme"></i>
                @else
                    <i class= "bi-sun" wire:click="toggleTheme"></i>
                @endif

            </div>

            <div class="me-0 px-4 my-auto">
                <i class="bi-search" wire:click="toggleSearch"></i>
            </div>

        </div>

        <div class="w-100 d-md-flex d-lg-none align-items-center" dir="rtl">

            <div class="d-flex align-items-center w-100 position-relative">

                <!-- راست: آیکن همبرگر (تریگر منو) -->
                <button class="navbar-toggler position-absolute top-50 translate-middle-y text-white"
                        style="right: 1.5rem; color:white !important;"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#fullscreenMenu" aria-controls="fullscreenMenu"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-white fw-bold"></span>

                    @auth()
                    @if(($unreadNotice ?? collect())->count()>0)
                        <sup class="bg-danger text-light rounded-5 px-1">{{ ($unreadNotice ?? collect())->count() }}</sup>
                    @endif
                    @endauth
                </button>

                <!-- وسط: برند (واقعاً وسط صفحه) -->
                <a class="navbar-brand text-light mx-auto text-center" href="/">
                    <h1 class="m-0">برناپیشرو</h1>
                </a>

                <!-- چپ: آیکن سرچ با فاصله از کنار -->
                <div class="position-absolute top-50 translate-middle-y"
                     style="left: 1.5rem;">
                    <i class="bi-search fs-5"></i>
                </div>
            </div>

            <!-- منوی فول‌اسکرین -->
            <div class="collapse fullscreen-menu bg-body text-body" id="fullscreenMenu">
                <div class="menu-content d-flex flex-column justify-content-between h-100 text-center">

                    <!-- بالای بالا: کلوز راست، سوییچ چپ -->
                    <div class="d-flex justify-content-between align-items-center p-3">

                        <!-- راست: دکمه بستن -->
                        <button type="button" class="btn-close" data-bs-toggle="collapse"
                                data-bs-target="#fullscreenMenu" aria-label="Close"></button>

                        <!-- چپ: سوییچ حالت روشن/تیره -->
                        <div class="form-check form-switch ms-2">
                            <input class="form-check-input" type="checkbox" id="themeSwitch"
                                   @if($theme === 'dark') checked @endif
                                   wire:click="toggleTheme">
                            <label class="form-check-label" for="themeSwitch">
                                @if($theme === 'dark') حالت تیره @else حالت روشن @endif
                            </label>
                        </div>
                    </div>

                    <div class="row px-5 text-center mt-5">
                        @auth()
                        @if($unreadNotice->isNotEmpty())

                            @foreach($unreadNotice as $notice)


                                <a class="alert alert-{{$notice->style}} text-decoration-none py-1 mt-2" href="{{route('messages.show',$notice->id)}}" wire:navigate>
                                    {{$notice->title}}
                                </a>

                            @endforeach

                        @else

                        @endif
                        @endauth
                    </div>


                    <!-- وسط: لینک‌ها (کاملاً وسط چین) -->
                    <ul class="navbar-nav flex-column my-auto align-items-center px-0">
                        <li class="nav-item"><a class="nav-link text-body fs-3 mt-3 mx-auto" href="#">محصولات</a></li>
                        <li class="nav-item"><a class="nav-link text-body fs-3 mt-3 mx-auto" href="#">خدمات</a></li>
                        <li class="nav-item"><a class="nav-link text-body fs-3 mt-3 mx-auto" href="#">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link text-body fs-3 mt-3 mx-auto" href="#">ارتباط با ما</a></li>
                    </ul>

                    <!-- پایین: نام راست، خروج چپ روی قرمز -->
                    @auth
                        <div class="d-flex justify-content-between align-items-center text-white px-3 py-2 cs-navbar">
                            <a href="{{ route('profile') }}" class="text-decoration-none text-white">@if($name && $lastname) {{$name}} {{$lastname}} @endif</a href=>
                            <a href="" class="text-white text-decoration-none btn btn-danger px-5 py-2 rounded-4" wire:click="logout" wire:confirm="آیابرای خروج از وبسایت مطمئن هستید؟" wire:navigate>خروج</a>
                        </div>
                    @endauth

                    @guest
                        <div class="d-flex justify-content-between align-items-center text-white p-3">
                            <a href="{{route('login')}}" class="text-white text-decoration-none cs-button rounded-4 px-4 py-2" wire:navigate>ورود</a>
                            <a href="{{route('register')}}" class="text-white text-decoration-none cs-button rounded-4 px-4 py-2" wire:navigate>ثبت نام</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

    </div>
</nav>





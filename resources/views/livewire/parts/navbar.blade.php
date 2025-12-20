<nav class="cs-navbar navbar navbar-expand-lg text-light m-4 py-0 rounded-4" dir="rtl">

    <div class="container-fluid">

        <div class="w-100 d-none d-lg-flex">

            <a class="navbar-brand text-light" href="/"><h1>برناپیشرو</h1></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"></span>
            </button>

            @auth
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="#">محصولات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">خدمات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">ارتباط با ما</a></li>
                    </ul>
                </div>

                <!-- Example single danger button -->
                <div class="btn-group me-0 px-5 ">
                    <button type="button" class="btn dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false">
                        @if($name && $lastname)
                            {{$name}}  {{$lastname}}
                        @endif

                    </button>
                    <ul class="dropdown-menu text-end">
                        <li><a href="{{route('profile')}}" class="dropdown-item" wire:navigate> پروفایل </a></li>
                        <li><a href="" class="dropdown-item" wire:click="logout" wire:confirm="آیابرای خروج از وبسایت مطمئن هستید؟" wire:navigate> خروج </a></li>
                    </ul>
                </div>

            @endauth

            @guest
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('login')}}" wire:navigate>ورود</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('register')}}" wire:navigate>ثبت نام</a></li>
                    </ul>
                </div>
            @endguest


            <div class="me-0 px-4 my-auto">

                @if(  $theme === 'light')
                    <i class= "bi-moon" wire:click="toggleTheme"></i>
                @else
                    <i class= "bi-sun" wire:click="toggleTheme"></i>
                @endif

            </div>

            <div class="me-0 px-4 my-auto">
                <i class="bi-search"></i>
            </div>

        </div>

        <div class="w-100 d-none d-md-flex d-lg-none">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"></span>
            </button>

            @auth
                <div class="collapse navbar-collapse" id="navbarNav">

                    <!-- Example single danger button -->
                    <div class="btn-group me-0 px-5 ">
                        <button type="button" class="btn dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($name && $lastname)
                                {{$name}}  {{$lastname}}
                            @endif

                        </button>
                        <ul class="dropdown-menu text-end">
                            <li><a href="{{route('profile')}}" class="dropdown-item" wire:navigate> پروفایل </a></li>
                            <li><a href="" class="dropdown-item" wire:click="logout" wire:confirm="آیابرای خروج از وبسایت مطمئن هستید؟" wire:navigate> خروج </a></li>
                        </ul>
                    </div>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="#">محصولات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">خدمات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">ارتباط با ما</a></li>
                    </ul>

                    <div class="me-0 px-4 my-auto">

                        @if(  $theme === 'light')
                            <i class= "bi-moon" wire:click="toggleTheme"></i>
                        @else
                            <i class= "bi-sun" wire:click="toggleTheme"></i>
                        @endif

                    </div>

                    <div class="me-0 px-4 my-auto">
                        <i class="bi-search"></i>
                    </div>
                </div>

                <a class="navbar-brand text-light" href="/"><h1>برناپیشرو</h1></a>

            @endauth

            @guest
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('login')}}" wire:navigate>ورود</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="{{route('register')}}" wire:navigate>ثبت نام</a></li>
                    </ul>
                </div>
            @endguest




        </div>


    </div>


</nav>




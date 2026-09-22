{{--        list of pages--}}
<div class="col-xl-auto">

    <div class="col-auto d-none d-xl-inline">

        <ul class="list-group row py-2">

            <li class="cs-header-user list-group-item text-center border h-auto py-1"> <h5>کاربری</h5> </li>

            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('profile') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('profile')}}" wire:navigate> ویرایش پروفایل </a>
            </li>

            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('my-products') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('my-products')}}" wire:navigate> محصولات من </a>
            </li>

            @can('isManager')
                <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('users') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('users')}}" wire:navigate> مدیریت کاربران </a></li>
            @endcan

        </ul>
        @can('isOperator') {{-- just operators have access to these categories --}}
        <ul class="list-group row py-2">

            <li class="cs-header-web t list-group-item text-center border py-1"> <h5>وبسایت</h5> </li>
            @can('isManager')

                <li class="list-group-item list-group-item-action text-end py-1
            {{request()->routeIs('info') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('info')}}" wire:navigate> اطلاعات وبسایت
                    </a>
                </li>

                <li class="list-group-item list-group-item-action text-end py-1
             {{request()->routeIs('social') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('social')}}" wire:navigate>
                        صفحات مجازی
                    </a>
                </li>

                <li class="list-group-item list-group-item-action text-end py-1
             {{request()->routeIs('licenses') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('licenses')}}" wire:navigate>
                        مجوزها
                    </a>
                </li>

                <li class="list-group-item list-group-item-action text-end py-1
             {{request()->routeIs('categories') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('categories')}}" wire:navigate>
                        دسته‌بندی‌ ها
                    </a>
                </li>

                <li class="list-group-item list-group-item-action text-end py-1
             {{request()->routeIs('filters') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('filters')}}" wire:navigate>
                        فیلترها
                    </a>
                </li>

                <li class="list-group-item list-group-item-action text-end py-1
             {{request()->routeIs('notices') ? 'active-page' : ''}}">
                    <a class="nav-link" href="{{route('notices')}}" wire:navigate>
                        اعلانات
                    </a>
                </li>


            @endcan

            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('comms') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('comms')}}"> ارتباطات </a></li>

        </ul>

        @can('isAdmin'){{-- just manager & admins have access to these categories --}}
        <ul class="list-group row py-2">

            <li class="cs-header-product t list-group-item text-center border py-1"> <h5>محصولات</h5> </li>

            <li class="list-group-item list-group-item-action d-flex text-end py-1 {{request()->routeIs('products-management') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('products-management')}}" wire:navigate> مدیریت محصولات </a>

                @if($this->commentAlert(\App\Models\Product::class))
                    <span class="mx-auto text-bg-danger px-1 rounded-5">
                {{ $this->commentAlert(\App\Models\Product::class) }}
                </span>
                @endif

            </li>

            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('brands') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('brands')}}" wire:navigate> مدیریت برندها </a></li>

            <li class="list-group-item list-group-item-action text-end py-1 {{request()->routeIs('discounts') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('discounts')}}" wire:navigate> مدیریت تخفیف ها </a></li>

        </ul>

        <ul class="list-group row py-2">

            <li class="cs-header-mag t list-group-item text-center border py-1"> <h5>مقالات</h5> </li>

            <li class="list-group-item list-group-item-action d-flex text-end py-1 {{request()->routeIs('articles-management') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('articles-management')}}" wire:navigate> مدیریت مقالات </a>

                @if($this->commentAlert(\App\Models\Article::class))
                    <span class="mx-auto text-bg-danger px-1 rounded-5">
                {{ $this->commentAlert(\App\Models\Article::class) }}
                </span>
                @endif
            </li>

        </ul>

        <ul class="list-group row py-2">

            <li class="cs-header-service t list-group-item text-center border py-1"> <h5>خدمات</h5> </li>

            <li class="list-group-item list-group-item-action d-flex text-end py-1 {{request()->routeIs('services-management') ? 'active-page' : ''}}">
                <a class="nav-link" href="{{route('services-management')}}" wire:navigate> مدیریت خدمات </a>
                @if($this->commentAlert(\App\Models\Service::class))
                    <span class="mx-auto text-bg-danger px-1 rounded-5">
                    {{ $this->commentAlert(\App\Models\Service::class) }}
                </span>
                @endif

            </li>

        </ul>
        @endcan {{-- just manager & admins have access to these categories --}}
        @endcan {{-- just admins have access to these categories --}}

    </div>

    @if($showMenu)

        <div class="row mx-4 d-xl-none d-block" wire:click="closeMenu">
            <button class="my-2 btn-close my-4"></button>
        </div>

        <div class="row justify-content-center mb-5">

            <div class="row text-center border-bottom my-2">
                <h4>کاربری</h4>
            </div>

            <a href="{{route('profile')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-user {{request()->routeIs('profile') ? 'active-page' : ''}}">
                    ویرایش پروفایل
                </button>
            </a>

            <a href="{{route('my-products')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-user {{request()->routeIs('my-products') ? 'active-page' : ''}}">
                    محصولات من
                </button>
            </a>

            @can('isManager')
                <a href="{{route('users')}}" class="col-auto mx-auto" wire:navigate>
                    <button class="my-2 btn cs-header-user {{request()->routeIs('users') ? 'active-page' : ''}}">
                        مدیریت کاربران
                    </button>
                </a>
            @endcan

            @can('isOperator')


            <div class="row text-center border-bottom mt-3 mb-2">
                <h4>وبسایت</h4>
            </div>
                    @can('isManager')
            <a href="{{route('info')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('info') ? 'active-page' : ''}}">
                    اطلاعات وبسایت
                </button>
            </a>

            <a href="{{route('social')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('social') ? 'active-page' : ''}}">
                    صفحات مجازی
                </button>
            </a>

            <a href="{{route('licenses')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('licenses') ? 'active-page' : ''}}">
                    مجوزها
                </button>
            </a>

            <a href="{{route('categories')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('categories') ? 'active-page' : ''}}">
                    دسته‌بندی‌ ها
                </button>
            </a>

            <a href="{{route('filters')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('filters') ? 'active-page' : ''}}">
                    فیلترها
                </button>
            </a>

            <a href="{{route('notices')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-web {{request()->routeIs('notices') ? 'active-page' : ''}}">
                    اعلانات
                </button>
            </a>
                @endcan

                <a href="{{route('comms')}}" class="col-auto mx-auto" wire:navigate>
                    <button class="my-2 btn cs-header-web {{request()->routeIs('comms') ? 'active-page' : ''}}">
                        ارتباطات
                    </button>
                </a>




            @can('isAdmin'){{-- just manager & admins have access to these categories --}}

            <div class="row text-center border-bottom mt-3 mb-2">
                <h4>محصولات</h4>
            </div>

            <a href="{{route('products-management')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-product {{request()->routeIs('products-management') ? 'active-page' : ''}}">
                    مدیریت محصولات

                    @if($this->commentAlert(\App\Models\Product::class))
                        <span class="mx-auto text-bg-light text-danger fw-bolder px-1 rounded-5">
                            {{ $this->commentAlert(\App\Models\Product::class) }}
                        </span>
                    @endif

                </button>
            </a>

            <a href="{{route('discounts')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-product {{request()->routeIs('discounts') ? 'active-page' : ''}}">
                    مدیریت تخفیف ها
                </button>
            </a>

            <a href="{{route('brands')}}" class="col-auto mx-auto" wire:navigate>
                <button class="my-2 btn cs-header-product {{request()->routeIs('brands') ? 'active-page' : ''}}">
                    مدیریت برندها
                </button>
            </a>

                <div class="row text-center border-bottom mt-3 mb-2">
                    <h4>مقالات</h4>
                </div>

                <a href="{{route('articles-management')}}" class="col-auto mx-auto" wire:navigate>
                    <button class="my-2 btn cs-header-mag {{request()->routeIs('articles-management') ? 'active-page' : ''}}">
                        مدیریت مقالات
                        @if($this->commentAlert(\App\Models\Article::class))
                            <span class="mx-auto text-bg-light text-danger fw-bolder px-1 rounded-5">
                                {{ $this->commentAlert(\App\Models\Article::class) }}
                             </span>
                        @endif
                    </button>
                </a>

                <div class="row text-center border-bottom mt-3 mb-2">
                    <h4>خدمات</h4>
                </div>

                <a href="{{route('services-management')}}" class="col-auto mx-auto" wire:navigate>
                    <button class="my-2 btn cs-header-service {{request()->routeIs('services-management') ? 'active-page' : ''}}">
                        مدیریت خدمات
                        @if($this->commentAlert(\App\Models\Service::class))
                            <span class="mx-auto text-bg-light text-danger fw-bolder px-1 rounded-5">
                                {{ $this->commentAlert(\App\Models\Service::class) }}
                             </span>
                        @endif
                    </button>
                </a>

                @endcan
            @endcan

        </div>

    @endif


    <div class="row mx-4 d-xl-none d-block mb-5">

        <button class="mx-auto cs-button w-auto py-1 border border-secondary d-inline-flex
        {{$this->anyAlert() ? 'pe-4 rounded-4' : 'px-2 rounded-3'}}"
                wire:click="menuToggle">

            <span class="col-auto my-auto text-center"> {{ $showMenu == true ? 'بستن منو' : 'مشاهده منو' }} </span>

            @if($this->anyAlert())
                <i class="col-auto fs-1 bi-dot text-danger my-auto"></i>
            @endif

        </button>
    </div>

</div>



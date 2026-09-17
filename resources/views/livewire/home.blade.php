<div class="container-fluid py-0" style="min-height: 100%;">

        {{--  Notice Slider  --}}
    @if($this->notificationSlider->isNotEmpty() && count($this->notificationSlider) > 1)

        {{-- resources/views/livewire/slider-component.blade.php --}}
        <div id="NoticeSlider" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                @foreach($this->notificationSlider as $index => $notice)
                    <button type="button" data-bs-target="#NoticeSlider" data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"
                            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <!-- The slideshow -->
            <div class="carousel-inner">
                @foreach($this->notificationSlider as $index => $notice)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="home-tile row bg-{{ $notice->style }} text-light text-center mx-2 rounded-5">
                            <h2 class="mx-auto my-auto">{{ $notice->title }}</h2>
                            <p>{{ $notice->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#NoticeSlider" data-bs-slide="next">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#NoticeSlider" data-bs-slide="prev">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    @if(count($this->notificationSlider) == 1)
        @foreach($this->notificationSlider as $notice)
                <div class="home-tile row bg-{{ $notice->style }} text-light text-center mx-2 rounded-5">
                    <h2 class="mx-auto my-auto">{{ $notice->title }}</h2>
                    <p>{{ $notice->description }}</p>
                </div>
        @endforeach
    @endif

    <div class="row text-center mx-2">

    @forelse($this->notificationTile as $tile)
            <div class="col-auto py-5 rounded-5 bg-{{$tile->style}} text-light mx-auto mt-5">
                <h2 class="mx-auto">{{$tile->title}}</h2>
            </div>
    @empty

    @endforelse

    </div>

    {{--    Service Slider    --}}
    @if($this->serviceSlider->isNotEmpty() && count($this->serviceSlider) > 1)
        <h2 class="mt-5 mx-5"> خدمات </h2>
        {{-- resources/views/livewire/slider-component.blade.php --}}
        <div id="ServiceSlider" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                @foreach($this->serviceSlider as $index => $service)
                    <button type="button" data-bs-target="#ServiceSlider" data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"
                            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <!-- The slideshow -->
            <div class="carousel-inner">

                @foreach($this->serviceSlider as $index => $service)

                    <a href="{{ route('service.show',$service->id) }}" class="text-decoration-none">

                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">

                            <div class="home-tile row border text-light text-center mx-2 rounded-5"
                                 style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">

                                <h2 class="mx-auto my-auto bg-secondary opacity-75 w-auto rounded-4 p-2">{{ $service->title }}</h2>
                                <div class="bg-secondary h-75 bg-opacity-75">{{ $service->intro }}</div>
                            </div>

                        </div>
                    </a>

                @endforeach
            </div>
            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#ServiceSlider" data-bs-slide="next">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#ServiceSlider" data-bs-slide="prev">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    @if(count($this->serviceSlider) == 1)
        @foreach($this->serviceSlider as $service)

            <a href="{{ route('service.show',$service->id) }}" class="text-decoration-none">
                <div class="home-tile row bg-{{ $service->style }} text-light text-center mx-2 rounded-5 my-auto" style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                    <h2 class="mx-auto my-auto bg-secondary opacity-75 w-auto rounded-4 p-2">{{ $service->title }}</h2>
                    <div class="bg-secondary h-75 bg-opacity-75">{{ $service->intro }}</div>
                </div>
            </a>

        @endforeach
    @endif



        @if($this->productSlider->isNotEmpty())
        <h2 class="mt-5 mx-5">آخرین محصولات</h2>
        {{-- فقط در این صفحه، فایل مخصوص سوییپر از طریق Vite لود می‌شود --}}
        @vite(['resources/js/home-swiper.js'])

            <div wire:ignore class="product-swiper swiper" style="position: relative;">
                <div class="swiper-wrapper">
                    @foreach($this->productSlider as $product)
                        <div class="swiper-slide">
                            <a href="{{ route('product.show',$product->id) }}" class="col-xl-2 col-md-4 py-3 mx-auto delete-badge text-decoration-none">

                                <div class="main-img text-center overflow-hidden border bg-white pb-3 mb-0 rounded-top-4">
                                    <img class="rounded-top-4" src="{{asset('storage/products/'.$product->image) }}" height="180" alt="پیش نمایش">

                                    <div class="row mt-3"> <h4 style="color:#84919e"> {{$product->name}} </h4> </div>

                                </div>

                                @if($product->supply == 0)
                                    <div class="bg-danger text-white row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                        <span class="fw-bolder"> ناموجود </span>
                                    </div>
                                @elseif($product->price == null)
                                    <div class="cs-navbar row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                        <span class="fw-bolder">استعلام بگیرید</span>
                                    </div>
                                @elseif($product->discount != 0 || $product->discount != null)
                                    <div class="bg-success text-white row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                        <span class="col-4 text-decoration-line-through">{{ number_format($product->price) }} </span>
                                        <span class="col-8 text-start">{{ number_format($product->price - ($product->price * ($product->discount/100)) ) }} تومان </span>
                                    </div>
                                @else
                                    <div class="cs-navbar2 row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                        <span class="fw-bolder">{{ number_format($product->price) }} تومان </span>
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        @endif




        {{--    Magazine Slider    --}}
        @if($this->articleSlider->isNotEmpty() && count($this->articleSlider) > 1)

        <h2 class="mt-5 mx-5"> آخرین مقالات </h2>

            {{-- resources/views/livewire/slider-component.blade.php --}}
            <div id="MagSlider" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    @foreach($this->articleSlider as $index => $article)
                        <button type="button" data-bs-target="#MagSlider" data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <!-- The slideshow -->
                <div class="carousel-inner">
                    @foreach($this->articleSlider as $index => $article)

                        <a href="{{ route('article.show',$article->id) }}" class="text-decoration-none">
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">

                                <div class="home-tile row border text-light text-center mx-2 rounded-5"
                                     style="background-image: url({{asset('storage/article_covers/'.$article->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">

                                    <h1 class="mx-auto my-auto bg-secondary opacity-75 w-auto rounded-4 p-2">{{ $article->title }}</h1>
                                    <div class="bg-secondary h-75 bg-opacity-75">{{ $article->intro }}</div>
                                </div>

                            </div>
                        </a>

                    @endforeach
                </div>
                <!-- Left and right controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#MagSlider" data-bs-slide="next">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#MagSlider" data-bs-slide="prev">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif

        @if(count($this->articleSlider) == 1)
            @foreach($this->articleSlider as $article)
            <a href="{{ route('article.show',$article->id) }}" class="text-decoration-none">
                <div class="home-tile row bg-{{ $article->style }} text-light text-center mx-2 rounded-5 my-auto"
                     style="background-image: url({{asset('storage/article_covers/'.$article->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                    <h2 class="mx-auto my-auto bg-secondary opacity-75 w-auto rounded-4 p-2">{{ $article->title }}</h2>
                    <div class="bg-secondary h-75 bg-opacity-75">{{ $article->intro }}</div>
                </div>
            </a>

            @endforeach
        @endif

</div>

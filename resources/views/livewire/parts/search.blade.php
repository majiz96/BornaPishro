<div class="container-fluid">

    @if($panel)
        <div class="row my-4 py-3 px-5 text-center">

{{--            <i class="bi-x text-danger h3 mx-auto" wire:click="closeSearchPanel"></i>--}}

            <button class="btn btn-outline-danger w-auto mx-auto p-1 my-2 d-flex" wire:click="closeSearch">
                <i class="bi-x h4 my-auto pb-0 d-flex"></i>
            </button>

            <button class="btn btn-outline-primary w-auto mx-auto p-1 my-2 d-flex" wire:click="eraseSearch">
                <i class="bi-eraser h4 my-auto pb-0 d-flex"></i>
            </button>

            <input type="search" class="form-control rounded-3 mx-auto" wire:model.live="search">

        </div>

        {{--   Show search result of products   --}}
        @if($this->getProducts->isNotEmpty())

            <h3 class="mx-5"> محصولات </h3>

            <div class="row py-3 px-5 text-center">

                @foreach($this->getProducts as $product)

                    <a href="{{ route('product.show',$product->id) }}" class="col-auto mx-auto text-decoration-none">

                        <div class="row rounded-4 px-0 my-2 cs-navbar">
                            <div class="col-auto px-0">
                                <img class="rounded-end-4" src="{{asset('storage/products/'.$product->image) }}" height="75" alt="پیش نمایش">
                            </div>
                            <div class="col-auto my-auto">{{$product->name}}</div>
                        </div>

                    </a>

                @endforeach

            </div>

        @endif

        {{--   Show search result of services   --}}
        @if($this->getServices->isNotEmpty())

            <h3 class="mx-5"> خدمات </h3>

            <div class="row py-3 px-5 text-center border-top">

                @foreach($this->getServices as $service)

                    <a href="{{ route('product.show',$service->id) }}" class="col-auto mx-auto text-decoration-none">

                        <div class="row border rounded-4 px-0 my-2 cs-navbar">

                            <div class="col-12 px-0">
                                <img class="rounded-top-4 w-100" src="{{asset('storage/service_covers/'.$service->cover) }}" height="75" alt="پیش نمایش">
                            </div>

                            <div class="col-8 text-center mx-auto">{{$service->title}}</div>
                        </div>


                    </a>

                @endforeach

            </div>

        @endif


        {{--   Show search result of articles   --}}
        @if($this->getArticles->isNotEmpty())

            <h3 class="mx-5"> مقالات </h3>

            <div class="row py-3 px-5 text-center border-top">

                @foreach($this->getArticles as $article)

                    <a href="" class="col-auto mx-auto w-auto text-decoration-none">

                        <div class="row border rounded-4 px-0 my-2 cs-navbar">

                            <div class="col-12 px-0">
                                <img class="rounded-top-4 w-100" src="{{asset('storage/article_covers/'.$article->cover) }}" height="75" alt="پیش نمایش">
                            </div>

                            <div class="col-8 text-center mx-auto">{{$article->title}}</div>
                        </div>

                    </a>

                @endforeach

            </div>

        @endif




    @endif

    @if($modalSearch)
        @include('modals.modal-search')
    @endif


</div>

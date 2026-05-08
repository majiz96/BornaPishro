<!-- Modal -->


@if($modalSearch)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-md-10 col-8">
                        <input type="search" class="form-control rounded-3 mx-auto" wire:model.live="search">
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn me-0" wire:click="eraseSearch">
                            <i class="bi-eraser h5"></i>
                        </button>
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeModalSearch"></button>
                    </div>
                </div>

                <div class="modal-body px-5">

                    {{-- Show Products in modal --}}
                    @if($this->getProducts->isNotEmpty())

                        <h3 class="mx-5"> محصولات </h3>
                        @foreach($this->getProducts as $product)
                            <a href="{{ route('product.show',$product->id) }}" class="row mx-auto text-decoration-none rounded my-2 border py-2 px-3 text-body">
                                {{$product->name}}
                            </a>
                        @endforeach

                    @endif

                    {{-- Show Services in modal --}}
                    @if($this->getServices->isNotEmpty())

                        <h3 class="mx-5 mt-5"> خدمات </h3>
                        @foreach($this->getServices as $service)
                            <a href="" class="row mx-auto text-decoration-none rounded my-2 border py-2 px-3 text-body ">
                                {{$service->title}}
                            </a>
                        @endforeach

                    @endif

                    {{-- Show Articles in modal --}}
                    @if($this->getArticles->isNotEmpty())

                        <h3 class="mx-5 mt-5"> مقالات </h3>
                        @foreach($this->getArticles as $article)
                            <a href="" class="row mx-auto text-decoration-none rounded my-2 border py-2 px-3 text-body ">
                                {{$article->title}}
                            </a>
                        @endforeach

                    @endif




                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeModalSearch">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



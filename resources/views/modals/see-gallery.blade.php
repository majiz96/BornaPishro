<!-- Modal -->


@if($galleryModal)

    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> {{ $modalTitle }}  </h1>
                    </div>

                    <div class="col-1 text-start">
                        <button type="button" class="btn-close me-0"  wire:click="closeGallery"></button>
                    </div>
                </div>

                <div class="modal-body px-5 text-center">
                    <div class="col-auto px-0">
                        @if($gallery_id)

                            @if($this->chosenPic->isNotEmpty())
                                @foreach($this->chosenPic as $picture)
                                    <img class="delete-badge" src="{{asset('storage/gallery/'.$picture->image) }}" height="256">
                                @endforeach
                            @endif

                        @else
                            <img class="delete-badge" src="{{asset('storage/products/'.$product->image) }}" height="256">
                        @endif
                    </div>
                </div>

                {{-- Gallery Pics  --}}
                @if($this->gallery->isNotEmpty())
                    <div class="row text-center py-2" style="min-height: 7vh">

                        @if($gallery_id)
                            <div class="col-xl-1 col-3 border text-center my-auto gallery-img py-3 delete-badge">
                                <img src="{{ asset('storage/products/'.$product->image) }}" alt="" wire:click="resetGallery">
                            </div>
                        @endif

                        @foreach($this->gallery as $gallery)
                            <div class="col-xl-1 col-3 border text-center my-auto gallery-img py-3 delete-badge">
                                <img src="{{ asset('storage/gallery/'.$gallery->image) }}" alt="" wire:click="selectPic({{$gallery->id}})">
                            </div>
                        @endforeach

                    </div>
                @endif


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeGallery">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



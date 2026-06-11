<div class="container">

    <div class="row mt-4"><h2>{{$product->name ?? 'محصول'}}</h2></div>

    {{--  Pictures  and Briefs  --}}
    <div class="row">
        <div class="col-xl-4 side-img2">
            <div class="row">

                @if($gallery_id)

                    @if($this->chosenPic->isNotEmpty())
                        @foreach($this->chosenPic as $picture)
                            <img class="delete-badge" src="{{asset('storage/gallery/'.$picture->image) }}" wire:click="showGallery({{$picture->id}})">
                        @endforeach
                    @endif

                @else
                    <img class="delete-badge" src="{{asset('storage/products/'.$product->image) }}" wire:click="showGallery(0)">
                @endif


            </div>

            {{-- Gallery Pics  --}}
            @if($this->gallery->isNotEmpty())
                <div class="row text-center py-2" style="min-height: 7vh">

                    @if($gallery_id)
                        <div class="col-xl-3 col-3 border text-center my-auto gallery-img py-3 delete-badge">
                            <img src="{{ asset('storage/products/'.$product->image) }}" alt="" wire:click="resetGallery">
                        </div>
                    @endif

                    @foreach($this->gallery as $gallery)
                       <div class="col-xl-3 col-3 border text-center my-auto gallery-img py-3 delete-badge">
                           <img src="{{ asset('storage/gallery/'.$gallery->image) }}" alt="" wire:click="selectPic({{$gallery->id}})">
                       </div>
                    @endforeach

                </div>
            @endif


        </div>

        {{--  Briefs --}}
        <div class="col-xl-8">

            <div class="row px-1">
                <ul class="mt-4">
                    @foreach($this->briefs as $brief)

                        @foreach($brief->units as $unit)

                            <li class="my-2">

                                {{$unit->title}} :

                                @foreach($unit->values as $value)
                                    {{$value->value}}
                                    @if($value->suffix)
                                        {{$value->suffix}}
                                    @endif
                                @endforeach


                            </li>

                        @endforeach

                    @endforeach
                </ul>
            </div>

            <div class="row px-1">
                {{$product->intro}}
            </div>

        </div>

    </div>


    {{-- Price & Options --}}
    <div class="row text-center my-3">

        @if(count($this->specifications)<= 1)

            @if($product->price !== 0 || $product->price !== null)
                <h3 class="text-success"> {{ number_format($product->price) }} تومان</h3>
            @elseif($product->supply == 0)
                <h3 class="text-danger"> ناموجود </h3>
            @else
                <h3 style="color: #84919e"> برای استعلام تماس بگیرید </h3>
            @endif


        @else
            @foreach($this->specifications as $spec)

                <a class="col-auto text-decoration-none text-body py-1 px-4 my-auto">

                    <div class="row border rounded-4 pt-1 pb-2 px-2 {{$activeTable == $spec->id ? 'cs-navbar' : ''}}">
                        <div class="col-12 delete-badge my-auto text-center h5" wire:click="selectTable({{$spec->id}})">{{$spec->name}}</div>
                    </div>
                </a>

            @endforeach

            <div class="col"></div>
            <div class="col-3 h3 text-success my-auto"> {{ number_format($activePrice) }} تومان </div>

        @endif

    </div>

    {{-- Tabs --}}
    <div class="row border rounded-top-4" style="min-height: 5vh">

        <div class="col-xl-1 col-3 my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-spec-outlined" autocomplete="off" wire:model.live="tab" value="specifications">
            <label class="btn btn-outline-primary w-auto py-1 rounded-3" for="btn-check-spec-outlined">مشخصات</label>
        </div>

        <div class="col-xl-1 col-3 my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-file-outlined" autocomplete="off" wire:model.live="tab" value="files">
            <label class="btn btn-outline-primary w-auto py-1 rounded-3" for="btn-check-file-outlined"> فایل ها </label>
        </div>

        <div class="col-xl-1 col-3 my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-source-outlined" autocomplete="off" wire:model.live="tab" value="sources">
            <label class="btn btn-outline-primary w-auto py-1 rounded-3" for="btn-check-source-outlined"> منابع </label>
        </div>

        <div class="col-xl-1 col-3 my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-video-outlined" autocomplete="off" wire:model.live="tab" value="videos">
            <label class="btn btn-outline-primary w-auto py-1 rounded-3" for="btn-check-video-outlined"> ویدیوها </label>
        </div>

    </div>

    {{-- Specification --}}
    <div class="row border rounded-bottom-4 p-2">

        @if($tab == 'specifications')

            @forelse($this->selectedSpecification as $specification)

                @foreach($specification->group as $group)

                    <div class="row text-end text-primary h5 my-3 fw-bolder me-1"> - {{$group->title}} </div>

                    @forelse($group->units as $units)
                        <div class="row text-end border rounded mx-auto my-1 py-1" dir="rtl">

                            <div class="col-1 fw-bold border-start">{{$units->title}} </div>


                            @forelse($units->values as $value)
                                <div class="col-auto text-end">
                                    {{$value->value}}
                                    {{$value->suffix}}
                                </div>
                            @empty
                                <div class="row text-center"> هیج پاسخ و مقداری برای این مشخصه درج نشده است </div>
                            @endforelse

                        </div>
                    @empty
                        <div class="row text-center"> هیج مشخصاتی برای این گروه درج نشده است </div>
                    @endforelse

                @endforeach

            @empty
                <div class="row text-center h3"> هیج مشخصاتی برای این جدول درج نشده است </div>
            @endforelse



        @elseif($tab == 'files')

            @forelse($this->files as $file)

                <div class="row mx-auto border rounded my-1">

                    <div class="col-auto my-auto py-1"> {{$file->file}} </div>
                    <div class="col-auto h5 text-success my-auto py-1 delete-badge"> <div class="bi-download" wire:click="download({{$file->id}})"></div> </div>

                </div>

            @empty
                <div class="row text-center h5"> این محصول فایلی برای دانلود ندارد </div>
            @endforelse

        @elseif($tab == 'sources')

            @forelse($this->sources as $source)
                <div class="row mx-auto my-1">
                    <a href="{{$source->url}}" class="text-decoration-none" target="_blank"> {{$source->title}} </a>
                </div>
            @empty
                <div class="row text-center h5"> مرجعی برای این محصول درج ثبت نشده است </div>
            @endforelse

        @elseif($tab == 'videos')

            @forelse($this->videos as $video)

                <div class="row mx-auto my-1">
                    @if($video->priority == 'آپارات')

                        @if($video->youtube)
                            <a href="https://youtu.be/{{$modalYoutube}}?si=c9qstIRQBH-kUg8P" class="text-danger text-decoration-none"> دیدن ویدیو در یوتوب </a>
                        @endif

                        <style>
                            .h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}
                            .h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:100%;height:100%;}</style>

                        <div class="h_iframe-aparat_embed_frame">
                            <span style="display: block;padding-top: 57%"></span>
                            <iframe src="https://www.aparat.com/video/video/embed/videohash/{{$video->aparat}}/vt/frame"
                                    allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                        </div>



                    @else

                        @if($modalAparat)
                            <div class="row">
                                <a href="https://www.aparat.com/v/{{$video->aparat}}" class="text-danger text-decoration-none"> دیدن ویدیو در آپارات </a>
                            </div>
                        @endif

                        <div class="row">
                            <iframe width="2240" height="1100" src="https://www.youtube.com/embed/{{$video->youtube}}?si=Z8XTCDCeU9G-MZim"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;
                                clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe>
                        </div>


                    @endif
                </div>
            @empty
                <div class="row text-center h5"> ویدیویی برای این محصول درج ثبت نشده است </div>
            @endforelse

        @else
            محتوای مورد نظر یافت نشد
        @endif

    </div>

    {{-- Comments --}}
    <form wire:submit.prevent="save" class="row mt-4 border rounded-4 p-2">

        <textarea id="text" class="form-control" rows="4" wire:model.blur="text"></textarea>
        @error('text') <small class="text-danger"> {{$message}} </small> @enderror

        <button type="submit" class="btn btn-primary mt-2 w-auto mx-auto"> ارسال </button>

    </form>

    <div class="row mt-4 p-3 border rounded-4">

        @if($this->Comments->isNotEmpty())

            @foreach($this->Comments as $comment)
                @include('livewire.comment-item',['comment'=>$comment,'depth'=>0])
            @endforeach

        @else
            <div class="row text-center py-2 my-auto"> <h3 class="my-auto"> کامنتی برای این محصول ثبت نشده است </h3> </div>
        @endif

    </div>


    @include('modals.see-gallery')

</div>

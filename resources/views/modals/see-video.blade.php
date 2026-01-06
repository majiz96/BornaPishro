<!-- Modal -->


@if($videoModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> {{ $modalTitle }}  </h1>
                    </div>

                    <div class="col-1 text-start">
                        <button type="button" class="btn-close me-0"  wire:click="$set('videoModal',false)"></button>
                    </div>
                </div>

                <div class="modal-body px-5 text-center">

                    @if($modalPriority == 'آپارات')

                        @if($modalYoutube)
                        <a href="https://youtu.be/{{$modalYoutube}}?si=c9qstIRQBH-kUg8P" class="text-danger text-decoration-none"> دیدن ویدیو در یوتوب </a>
                        @endif

                        <style>
                            .h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}
                            .h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:75%;height:75%;}</style>

                        <div class="h_iframe-aparat_embed_frame">
                            <span style="display: block;padding-top: 57%"></span>
                            <iframe src="https://www.aparat.com/video/video/embed/videohash/{{$modalVideo}}/vt/frame"
                                    allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                        </div>



                    @else

                        @if($modalAparat)
                            <div class="row">
                            <a href="https://www.aparat.com/v/{{$modalAparat}}" class="text-danger text-decoration-none"> دیدن ویدیو در آپارات </a>
                            </div>
                        @endif

                    <div class="row">
                        <iframe width="2240" height="1100" src="https://www.youtube.com/embed/{{$modalVideo}}?si=Z8XTCDCeU9G-MZim"
                                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;
                                clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                    </div>





                    @endif



                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="$set('videoModal',false)">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



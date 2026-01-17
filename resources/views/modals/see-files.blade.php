<!-- Modal -->


@if($filesModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> فایلهای {{ $modalName !== null ? $modalName : $modalUser }}  </h1>
                    </div>

                    <div class="col-1 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeFiles"></button>
                    </div>
                </div>

                <div class="modal-body px-5">

                    @if($modalErr)
                        <div class="alert alert-danger">
                            {{$modalErr}}
                        </div>
                    @endif

                        <div class="row px-2">
                        @foreach($modalFiles as $fid => $files)

                            <div class="col-xl-3 my-3 px-3">

                                <div class="row border rounded-4 py-1 px-3">

                                    <div class="col-xl-11 text-nowrap">
                                        {{$files}}
                                    </div>

                                    <div class="col-xl-1 text-start">
                                        <i class="bi-download text-primary fw-bolder" wire:click="download({{$fid}})"></i>
                                    </div>


                                </div>


                            </div>


                        @endforeach
                        </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeFiles">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



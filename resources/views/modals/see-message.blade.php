<!-- Modal -->


@if($messageModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> {{ $modalSubject }}  </h1>
                    </div>

                    <div class="col-1 text-xxl-start text-xl-end">
                        <button type="button" class="btn-close me-0"  wire:click="$set('messageModal',false)"></button>
                    </div>
                </div>

                <div class="modal-body px-5 text-center"> {!! $modalMessage !!} </div>


                <div class="modal-footer row d-flex" dir="rtl">

                    <div class="col-xl-auto text-end">
                        نویسنده:
                        &nbsp;
                        {{$modalName}}
                    </div>

                    <div class="col-xl-auto">
                        <h1 class="modal-title fs-5"> {{ $modalMail }}  </h1>
                    </div>


                    <div class="col-xl-auto flex-fill"></div>

                    <div class="col-xl-1">
                        <button type="button" class="btn btn-secondary" wire:click="$set('messageModal',false)">
                            بازگشت
                        </button>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endif



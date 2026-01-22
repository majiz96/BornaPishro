<!-- Modal -->


@if($modal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> {{ $modalTitle }}  </h1>
                    </div>

                    <div class="col-1 text-start">
                        <button type="button" class="btn-close me-0"  wire:click="$set('modal',false)"></button>
                    </div>
                </div>

                <div class="modal-body px-5 text-center"> {{$modalContent}} </div>


                <div class="modal-footer row" dir="rtl">

                    <div class="col-xl-1 text-end">
                        نویسنده:
                        &nbsp;
                        {{$modalWriter}}
                    </div>

                    <div class="col-xl-1 text-end">
                        ویراستار:
                        &nbsp;
                        {{$modalEditor}}
                    </div>

                    <div class="col-xl-8"></div>

                    <div class="col-xl-1">
                        <button type="button" class="btn btn-secondary" wire:click="$set('modal',false)">
                            بازگشت
                        </button>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endif



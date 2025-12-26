<!-- Modal -->


@if($seeModal)
    <div class="modal d-flex" tabindex="-1" dir="rtl">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> {{ $modalTitle }}  </h1>
                    </div>

                    <div class="col-1">
                        <button type="button" class="btn-close" wire:click="$set('seeModal',false)"></button>
                    </div>
                </div>
                <div class="modal-body">

                    {{$modalDescription}}

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('seeModal',false)">بازگشت</button>
                </div>
            </div>
        </div>
    </div>
@endif



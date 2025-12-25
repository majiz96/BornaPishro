<!-- Modal -->


@if($messageModal)
    <div class="modal d-flex" tabindex="-1" dir="rtl">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> پیام {{ $modalName !== null ? $modalName : $modalUser }}  </h1>
                    </div>

                    <div class="col-1">
                        <button type="button" class="btn-close" wire:click="closeMessage"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <h3> {{$modalSubject}} </h3>

                    {{$modalMessage}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeMessage">بازگشت</button>
                </div>
            </div>
        </div>
    </div>
@endif



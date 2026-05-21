<!-- Modal -->


@if($showOrders)

    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-md-11 col-9">
                        دسته ها
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeOrders"></button>
                    </div>
                </div>

                <div class="modal-body h-auto px-5">

                    <div class="row text-end mt-4"><h5> نمایش </h5></div>
                    <div class="row">

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-five-outlined" autocomplete="off" wire:model.live="perPage" value="5">
                            <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-five-outlined">۵</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-ten-outlined" autocomplete="off" wire:model.live="perPage" value="10">
                            <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-ten-outlined">۱۰</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-twentefive-outlined" autocomplete="off" wire:model.live="perPage" value="25">
                            <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-twentefive-outlined">۲۵</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-all-outlined" autocomplete="off" wire:model.live="perPage" value="all">
                            <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-all-outlined">همه</label>
                        </div>


                    </div>

                    <div class="row text-end mt-4"><h5> براساس </h5></div>
                    <div class="row">

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-date-outlined" autocomplete="off" wire:model.live="sort" value="created_at">
                            <label class="btn btn-outline-danger w-auto rounded-5 py-2" for="btn-check-date-outlined">تاریخ</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-title-outlined" autocomplete="off" wire:model.live="sort" value="title">
                            <label class="btn btn-outline-danger w-auto rounded-5 py-2" for="btn-check-title-outlined">نام</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-category-outlined" autocomplete="off" wire:model.live="sort" value="category_id">
                            <label class="btn btn-outline-danger w-auto rounded-5 py-2" for="btn-check-category-outlined">دسته</label>
                        </div>

                    </div>

                    <div class="row text-end mt-4"><h5> به ترتیب </h5></div>
                    <div class="row">
                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-asc-outlined" autocomplete="off" wire:model.live="direction" value="asc">
                            <label class="btn btn-outline-success w-auto rounded-5 py-2" for="btn-check-asc-outlined">صعودی</label>
                        </div>

                        <div class="col-auto my-auto text-center">
                            <input type="radio" class="btn-check mx-3" id="btn-check-desc-outlined" autocomplete="off" wire:model.live="direction" value="desc">
                            <label class="btn btn-outline-success w-auto rounded-5 py-2" for="btn-check-desc-outlined">نزولی</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeOrders">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



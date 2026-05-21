<!-- Modal -->


@if($showFilters)

    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-md-11 col-9">
                        دسته ها
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeFilters"></button>
                    </div>
                </div>

                <div class="modal-body px-5">

                    <div class="row">
                        @if($this->filters->isNotEmpty())
                            @foreach($this->filters as $filter)


                                @if($filter->type == 'checkbox')

                                    <input type="checkbox" class="btn-check" id="btn-check-{{$filter->id}}-outlined-filter" wire:model.live="activeFilter" value="{{$filter->id}}">

                                    <label class="col-md-3 col-sm-5 col-10 rounded-4 btn btn-outline-primary fw-bold border my-2 mx-auto" for="btn-check-{{$filter->id}}-outlined-filter">{{$filter->title}}</label>

                                @else
                                    <label class="" for="range-{{$filter->id}}">{{$filter->title}}</label>

                                    <input type="range" class="form-range" id="range-{{$filter->id}}">

                                @endif



                            @endforeach
                        @endif
                    </div>



                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeFilters">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



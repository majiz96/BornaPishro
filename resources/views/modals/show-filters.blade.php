<!-- Modal -->

    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-md-11 col-9">
                        فیلترها
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeFilters"></button>
                    </div>
                </div>

                <div class="modal-body ps-4">

                    <div class="row my-4 mx-auto bg-body">
                        @if($this->Filters->isNotEmpty())
                            @foreach($this->Filters as $filter)

                                @if($filter->options->count() <= 1)

                                    <div class="row mt-2 mx-auto px-0">

                                        @foreach($filter->options as $option)

                                            <div class="row my-1 d-flex mx-auto">

                                                <input type="checkbox" class="btn-check" id="btn-check-{{$option->id}}-outlined"
                                                       wire:model.live="activeOption" value="{{$option->id}}">

                                                <label class="col-auto mx-auto rounded-3 btn btn-outline-success border border-2 border-success fw-bolder"
                                                       for="btn-check-{{$option->id}}-outlined">
                                                    {{$option->name}}
                                                    ( {{$option->usedOptions()->count()}} )
                                                </label>

                                            </div>

                                        @endforeach
                                    </div>

                                @else

                                    <div class="card my-2 mx-auto px-0">

                                        <div class="card-header">
                                            <div class=" py-1 text-end mt-0 mx-auto"> {{$filter->title}} </div>
                                        </div>

                                        <div class="card-body px-0 row">
                                            @foreach($filter->options as $option)

                                                <input type="checkbox" class="btn-check" id="btn-check-{{$option->id}}-outlined"
                                                       wire:model.live="activeOption" value="{{$option->id}}">

                                                <label class="col-auto mx-auto rounded-3 btn btn-outline-success border border-2 border-success fw-bolder"
                                                       for="btn-check-{{$option->id}}-outlined">
                                                    {{$option->name}}
                                                    ( {{$option->usedOptions()->count()}} )
                                                </label>

                                            @endforeach
                                        </div>
                                    </div>

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



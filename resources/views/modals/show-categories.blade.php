<!-- Modal -->


    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-md-11 col-9">
                     دسته ها
                    </div>

                    <div class="col-md-1 col-2 text-start">
                        <button type="button" class="btn-close me-0" wire:click="closeCategories"></button>
                    </div>
                </div>

                <div class="modal-body px-5">


                    @if($this->categories->isNotEmpty())

                        @if(!empty($activeCategory) && count($activeCategory) !== count($this->categories))

                            <button class="col-12 btn btn-outline-danger rounded-4 fw-bold mx-auto" wire:click="categoryReset"> همه </button>

                        @else
                            <button class="col-12 btn btn-danger rounded-4 fw-bold"> همه </button>
                        @endif

                        @foreach($this->categories as $cat)

                            @if($cat->children->isNotEmpty())

                                <div class="col">

                                    <div class="row py-2 mx-auto mt-3 my-auto">

                                        <input type="checkbox" class="btn-check" id="btn-check-{{$cat->id}}-outlined" wire:model.live="activeCategory" value="{{$cat->id}}">

                                        <label class="col-12 rounded-4 btn btn-outline-primary fw-bold" for="btn-check-{{$cat->id}}-outlined">{{$cat->name}}</label>

                                        @foreach($cat->children as $child)

                                            <input type="checkbox" class="btn-check" id="btn-check-{{$child->id}}-outlined" wire:model.live="activeCategory" value="{{$child->id}}">

                                            <label class="col-auto mt-3 mx-auto rounded-5 btn btn-outline-secondary fw-bold" for="btn-check-{{$child->id}}-outlined">
                                                {{$child->name}}
                                            </label>

                                        @endforeach
                                    </div>

                                </div>

                            @elseif($cat->children->isEmpty() && $cat->parent_id == 0)

                                <div class="col-auto py-2 mx-auto mt-3 my-auto">

                                    <input type="checkbox" class="btn-check" id="btn-check-{{$cat->id}}-outlined" wire:model.live="activeCategory" value="{{$cat->id}}">
                                    <label class="col px-5 py-2 rounded-4 btn btn-outline-primary fw-bold" for="btn-check-{{$cat->id}}-outlined">{{$cat->name}}</label>

                                </div>

                            @endif

                        @endforeach
                    @else

                    @endif

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="closeCategories">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>



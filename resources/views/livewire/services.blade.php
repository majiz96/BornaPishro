<div class="container-fluid avoid-emptiness">


    <div class="row text-center border rounded-4 px-xl-5 pt-3 pb-2 mx-auto">

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

                            <label class="col-xl-12 rounded-4 btn btn-outline-primary fw-bold" for="btn-check-{{$cat->id}}-outlined">{{$cat->name}}</label>

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

    <div class="row border rounded-4 mx-1 my-4">

        <div class="col-xl-1 col-auto border rounded-end-4">
            @if($this->filters->isNotEmpty())
                @foreach($this->filters as $filter)

                    <div class="row m-2 text-end mx-auto">

                        <div class="col-auto">{{$filter->title}}</div>
                        <div class="col-auto"><input type="{{$filter->type}}" wire:model.live="activeFilter" value="{{$filter->id}}"></div>

                    </div>
                @endforeach
            @endif
        </div>

        <div class="col-xl-11 col-auto">
            <div class="row mt-3 mb-1 px-3">

                <div class="col-xl-2">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="جستجو...">
                </div>

                <div class="col-xl-1 my-auto">
                    <select wire:model.live="sort" class="form-select">
                        <option value="created_at"> تاریخ </option>
                        <option value="name">نام</option>
                        <option value="name">دسته</option>
                    </select>
                </div>

                <div class="col-xl-1 my-auto">
                    <select wire:model.live="direction" class="form-select">
                        <option value="desc">نزولی</option>
                        <option value="asc">صعودی</option>
                    </select>
                </div>

                <div class="col-xl-1 my-auto">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="all">همه</option>
                    </select>
                </div>

            </div>
        </div>
    </div>




</div>

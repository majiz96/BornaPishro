<div class="container-fluid avoid-emptiness">


    <div class="row text-center border rounded-4 px-xl-5 pt-3 pb-2 mx-auto d-none d-xl-flex">

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

    <div class="row border rounded-4 mx-1 my-4">

        <div class="col-xxl-2 col-xl-3 border rounded-end-4 d-none d-xl-inline-block">

            {{--       Filters        --}}
            <div class="row my-4 mx-auto bg-body">

                @if($this->Filters->isNotEmpty())
                    @foreach($this->Filters as $filter)

                        @if($filter->options->count() <= 1)

                            <div class="row mt-2 mx-auto px-0">

                                @foreach($filter->options as $option)
                                    <div class="row my-1 d-flex mx-auto">
                                        <div class="col-auto text-end mx-auto {{$activeOption == $option->id ? 'text-primary fw-bolder' : 'fw-bold'}}">
                                            {{$option->name}}
                                        </div>

                                        <div class="col-1 text-end flex-fill">
                                            ( {{$option->modelOptions->count()}} )
                                        </div>

                                        <div class="col-1 text-start">
                                            <input type="checkbox" class="form-check-input" value="{{$option->id}}" wire:model.live="activeOption">
                                        </div>
                                    </div>

                                @endforeach
                            </div>

                        @else

                            <div class="card my-2 mx-auto px-0">

                                <div class="card-header cs-navbar">
                                    <div class=" py-1 text-end mt-0 mx-auto"> {{$filter->title}} </div>
                                </div>

                                <div class="card-body px-0">
                                    @foreach($filter->options as $option)

                                        <div class="row my-1 d-flex mx-auto">
                                            <div class="col-auto text-end {{$activeOption == $option->id ? 'text-primary' : ''}}">
                                                {{$option->name}}
                                            </div>

                                            <div class="col-auto text-end">
                                                ( {{$option->modelOptions->count()}} )
                                            </div>

                                            <div class="col-1 text-start">
                                                <input type="checkbox" class="form-check-input" value="{{$option->id}}" wire:model.live="activeOption">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @endif




                    @endforeach

                @endif

            </div>

        </div>

        <div class="col-xxl-10 col-xl-9">

            <div class="row mt-3 mb-1 px-3 d-none d-xl-flex">

                <div class="col-xxl-2 col-xl-4">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="جستجو...">
                </div>

                <div class="col-xxl-1 col-xl-2 my-auto">
                    <select wire:model.live="sort" class="form-select">
                        <option value="created_at"> تاریخ </option>
                        <option value="title">نام</option>
                        <option value="category_id">دسته</option>
                    </select>
                </div>

                <div class="col-xxl-1 col-xl-2 my-auto">
                    <select wire:model.live="direction" class="form-select">
                        <option value="desc">نزولی</option>
                        <option value="asc">صعودی</option>
                    </select>
                </div>

                <div class="col-xxl-1 col-xl-2 my-auto">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="all">همه</option>
                    </select>
                </div>

            </div>

            <div class="row mt-3 mb-1 px-sm-3 d-xl-none d-xxl-none">

                <div class="col-md-5 col-sm-12 col-12 mx-auto"><input type="text" wire:model.live="search" class="form-control" placeholder="جستجو..."></div>

                <button class="col-md-2 col-sm-3 col-5 btn btn-primary mx-auto mt-md-0 mt-4"
                wire:click="openCategories">
                    <i class="bi-folder"></i>
                    دسته بندی
                </button>

                <button class="col-md-2 col-sm-3 col-5 btn btn-danger mx-auto mt-md-0 mt-4"
                wire:click="openFilters">
                    <i class="bi-funnel"></i> فیلتر ها
                </button>

                <button class="col-md-2 col-sm-3 col-11 btn btn-success mx-auto mt-md-0 mt-4"
                wire:click="openOrders">
                    <i class="bi-filter"></i> ترتیب
                </button>

            </div>

            <div class="row mt-3 mb-1 px-0">

            {{--      show services      --}}
            <div class="row py-5 px-0 text-center border-top mx-auto">

                @forelse($this->services as $service)

                    <a href="{{ route('service.show',$service->id) }}"
                       class="col-xxl-4 col-6 mx-auto mt-3 px-5 rounded-4 text-decoration-none
                        d-none d-xl-block">

                        <h5 class="row cs-article-heading me-1"> {{$service->title}} </h5>

                        <div class="card row rounded-4">
                            <div class="row cs-article-cover mx-auto rounded-top-4  px-0"
                                 style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                            </div>
                            <div class="row text-decoration-none text-body me-1 py-1">
                                {{$service->intro}}
                            </div>
                        </div>

                    </a>

                    <a href="{{ route('service.show',$service->id) }}"
                       class="row mx-auto mt-4 px-5 rounded-4 text-decoration-none
                        d-none d-sm-block d-xl-none d-xxl-none">

                        <h5 class="row cs-article-heading me-1 mx-auto"> {{$service->title}} </h5>

                        <div class="row border rounded-4 px-0 mx-auto">

                            <div class="row rounded-top-4 cs-article-cover mx-auto"
                                 style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                            </div>

                            <div class="row text-decoration-none text-body me-1 py-1 mx-auto">
                                {{$service->intro}}
                            </div>

                        </div>

                    </a>

                    <a href="{{ route('service.show',$service->id) }}"
                       class="row mx-auto mt-3 px-1 rounded-4 text-decoration-none
                       d-sm-none d-md-non d-xl-none d-xxl-none">

                        <span class="row cs-article-heading py-1 pe-4 fw-bolder"> {{$service->title}} </span>

                        <div class="row border rounded-3 px-0 mx-auto">

                            <div class="row rounded-top-3 cs-article-cover mx-auto"
                                style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                            </div>

                            <small class="row text-decoration-none text-body mx-auto text-end px-2 py-1">
                                {{$service->intro}}
                            </small>

                        </div>

                    </a>

                @empty

                   <div class="row text-center text-danger"> <h3> خدماتی ثبت نشده است </h3> </div>

                @endforelse

            </div>


        </div>


        </div>

        @if($perPage !== 'all')
            {{$this->services->links(data:['scrollTo',false])}}
        @endif

        @if($showFilters && $this->Filters->isNotEmpty())
            @include('modals.show-filters')
        @endif

        @if($showCategories)
            @include('modals.show-categories')
        @endif

        @if($showOrders)
            @include('modals.show-orders')
        @endif

    </div>

</div>

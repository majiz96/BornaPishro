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
            {{--      show services      --}}
            <div class="row py-5">

                @forelse($this->services as $service)

                    <a href="{{ route('product.show',$service->id) }}"
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

                    <a href="{{ route('product.show',$service->id) }}"
                       class="row mx-auto mt-3 px-3 rounded-4 text-decoration-none
                        d-none d-sm-block d-xl-none d-xxl-none">

                        <h5 class="row cs-article-heading me-1 mx-auto"> {{$service->title}} </h5>

                        <div class="row border rounded-4 px-0 mx-auto">

                            <div class="col-md-5 col-4 rounded-end-4 cs-article-cover"
                                 style="background-image: url({{asset('storage/service_thumbnails/'.$service->thumbnail) }});
                                background-size: cover;
                                background-position: center;
                                ">
                            </div>

                            <div class="col-md-6 col-7 text-decoration-none text-body me-1 ps-0 py-1">
                                {{$service->intro}}
                            </div>

                        </div>

                    </a>

                    <a href="{{ route('product.show',$service->id) }}"
                       class="row mx-auto mt-3 px-3 rounded-4 text-decoration-none
                       d-sm-none d-md-non d-xl-none d-xxl-none">

                        <h5 class="row cs-article-heading"> {{$service->title}} </h5>

                        <div class="row border rounded-4 px-0 mx-auto">

                            <div class="row rounded-top-4 cs-article-cover mx-auto"
                                style="background-image: url({{asset('storage/service_covers/'.$service->cover) }});
                                background-size: cover;
                                background-position: center;
                                ">
                            </div>

                            <div class="row text-decoration-none text-body me-1 ps-0 py-1">
                                {{$service->intro}}
                            </div>

                        </div>

                    </a>

                @empty

                    خدماتی در این گروه ثبت نشده است

                @endforelse

            </div>


        </div>
    </div>

    @if($perPage !== 'all')
        {{$this->services->links(data:['scrollTo',false])}}
    @endif


</div>

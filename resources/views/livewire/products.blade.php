<div class="container-fluid avoid-emptiness">

    {{--  Showing & selecting categories  --}}

        <div class="row text-center px-xl-5 px-4">

            <h2 class="my-auto">
                دسته ها
{{--                {{$category}}--}}
{{--                 ==--}}
{{--                @forelse($activeCategory as $active)--}}
{{--                    {{$active}}--}}
{{--                @empty--}}
{{--                    هیچ دسته منتخبی وجود ندارد--}}
{{--                @endforelse--}}
            </h2>
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

                                        <label class="col mt-3 mx-2 rounded-5 btn btn-outline-secondary fw-bold" for="btn-check-{{$child->id}}-outlined">
                                            {{$child->name}}
                                        </label>

                                    @endforeach
                                </div>

                            </div>

                        @elseif($cat->children->isEmpty() && $cat->parent_id == 0)

                            <div class="col py-2 mx-2 mt-3 my-auto">

                                <input type="checkbox" class="btn-check" id="btn-check-{{$cat->id}}-outlined" wire:model.live="activeCategory" value="{{$cat->id}}">
                                <label class="col px-5 py-2 rounded-4 btn btn-outline-primary fw-bold" for="btn-check-{{$cat->id}}-outlined">{{$cat->name}}</label>

                            </div>

                        @endif

                    @endforeach
                @else

                @endif

            </div>


            <div class="row mt-3 mb-1 px-3">

                <div class="col-xl-2">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="جستجو...">
                </div>

                <div class="col-xl-1 my-auto">
                    <select wire:model.live="sort" class="form-select">
                        <option value="created_at"> تاریخ </option>
                        <option value="name">نام</option>
                        <option value="brand_id">برند</option>
                        <option value="price">قیمت</option>
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

            <div class="col-lg-2 border home-blocks rounded-end-4 my-3 px-4">

                <div class="row my-3 px-3">

                    <div class="col-xl-11 text-end">
                        <label for="toggleSupply" class="cursor-pointer">
                            <span class="fw-bold">فقط محصولات موجود</span>
                        </label>
                    </div>

                    <div class="col-xl-1 text-end">
                        <input
                            type="checkbox"
                            id="toggleSupply"
                            wire:model.live="supplyCheck"
                            class="form-check-input cursor-pointer"
                            style="width: 1.2rem; height: 1.2rem;"
                        >
                    </div>

                </div>

                <div class="row my-3 px-3">

                    <div class="col-xl-11 text-end">
                        <label for="togglePrice" class="cursor-pointer">
                            <span class="fw-bold">فقط محصولات دارای قیمت</span>
                        </label>
                    </div>

                    <div class="col-xl-1 text-end">
                        <input
                            type="checkbox"
                            id="togglePrice"
                            wire:model.live="priceCheck"
                            class="form-check-input cursor-pointer"
                            style="width: 1.2rem; height: 1.2rem;"
                        >
                    </div>

                </div>

                <div class="my-5 px-3">
                    <h6 class="mb-3">محدوده قیمت:</h6>

                    <div wire:ignore>
                        <div id="priceSlider"></div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <small class="">{{ number_format($priceMin) }} تومان</small>
                        <small class="">{{ number_format($priceMax) }} تومان</small>
                    </div>

                </div>

                {{--       Filters        --}}
{{--                <div class="row">--}}
{{--                    @if($this->filters->isNotEmpty())--}}
{{--                        @foreach($this->filters as $filter)--}}

{{--                            <div class="row m-2 text-end border-bottom mx-auto">--}}
{{--                                <h5>{{$filter->title}}</h5>--}}

{{--                                @if($filter->units->isNotEmpty())--}}
{{--                                    @foreach($filter->units as $unit)--}}

{{--                                        @foreach($unit->values as $value)--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-xl-8 text-end">--}}
{{--                                                    {{$value->value}}--}}
{{--                                                    @if($value->suffix)--}}
{{--                                                        {{$value->suffix}}--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}

{{--                                                <div class="col-xl-4 text-start">--}}
{{--                                                    <input type="{{$filter->type}}" wire:model.live="activeFilter" value="{{$value->id}}">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <br>--}}
{{--                                        @endforeach--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}

{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </div>--}}

            </div>

            <div class="col-lg-10 border home-blocks rounded-start-4 my-3 px-4">

                <div class="row">

                    @foreach($this->products as $product)
                        <a href="{{ route('product.show',$product->id) }}" class="col-xl-2 col-md-4 py-3 mx-auto delete-badge text-decoration-none">

                            <div class="main-img text-center overflow-hidden border bg-white py-3 mb-0 rounded-top-4">
                                <img class="rounded-top-4" src="{{asset('storage/products/'.$product->image) }}" height="180" alt="پیش نمایش">

                                <div class="row mt-3 px-4"> <h4 style="color:#84919e"> {{$product->name}} </h4> </div>

                            </div>

                            @if($product->supply == 0)
                            <div class="bg-danger text-white row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                <span class="fw-bolder"> ناموجود </span>
                            </div>
                            @elseif($product->price == null)
                                <div class="cs-navbar row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                    <span class="fw-bolder">استعلام بگیرید</span>
                                </div>
                            @elseif($product->discount != 0 || $product->discount != null)
                                <div class="bg-success text-white row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                    <span class="col-4 text-decoration-line-through">{{ number_format($product->price) }} </span>
                                    <span class="col-8 text-start">{{ number_format($product->price - ($product->price * ($product->discount/100)) ) }} تومان </span>
                                </div>
                            @else
                                <div class="cs-navbar2 row my-auto mx-auto pt-1 pb-1 text-center border rounded-bottom-4 cs-border" dir="rtl">
                                    <span class="fw-bolder">{{ number_format($product->price) }} تومان </span>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>

            </div>

            @if($perPage !== 'all')
            {{$this->products->links(data:['scrollTo',false])}}
            @endif

        </div>


    {{--  Showing & selecting products --}}




</div>

<script>
    document.addEventListener('livewire:init', function() {
        const slider = document.getElementById('priceSlider');
        if (!slider) return;

        const sliderInstance = noUiSlider.create(slider, {
            start: [@js($priceMin), @js($priceMax)],
            connect: true,
            direction: 'rtl',
            range: {
                'min': @js($priceMin),
                'max': @js($priceMax)
            },
            step: 100000
        });

        sliderInstance.on('update', function(values) {
            @this.call('updatePriceRange',
                Math.round(values[0]),
                Math.round(values[1])
            );
        });

        Livewire.on('updateSlider', function(data) {
            sliderInstance.updateOptions({
                range: { min: data.min, max: data.max }
            });

            const currentValues = sliderInstance.get();
            let newMin = Math.max(currentValues[0], data.min);
            let newMax = Math.min(currentValues[1], data.max);

            if (newMin !== currentValues[0] || newMax !== currentValues[1]) {
                sliderInstance.set([newMin, newMax]);
            }
        });
    });
</script>


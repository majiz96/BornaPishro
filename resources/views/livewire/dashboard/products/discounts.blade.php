<div class="container">

    <div class="row text-center"><h2> تخفیف محصولات </h2>

        @foreach($selectedCategories as $group)
            {{$group}} ,
        @endforeach



    </div>

    <form class="row p-3 border rounded-4 my-4" wire:submit.prevent="save">

        @if($multiple)


            @foreach($this->productList as $list)
               <div class="row my-4 border">
                   <div class="col-xl-1">{{$counter++}}</div>
                   <div class="col-xl-2">{{$list->name}}</div>
                   <div class="col-xl-2 border border-left">{{number_format($list->price)}}</div>
                   <div class="col-xl-2">{{number_format($list->price - ($list->price * ($discount/100) ) )}}</div>
                   <div class="col-xl-3"></div>
               </div>
            @endforeach

        @elseif($grouped)

            @foreach($this->groupedList() as $list)
                @if($list->price > 0)
                    <div class="row my-4 border">
                        <div class="col-xl-1">{{$counter++}}</div>
                        <div class="col-xl-2">{{$list->name}}</div>
                        <div class="col-xl-2 border border-left">{{number_format($list->price)}}</div>
                        <div class="col-xl-2">{{number_format($list->price - ($list->price * ($discount/100) ) )}}</div>
                        <div class="col-xl-3"></div>
                    </div>
                @endif

            @endforeach

        @else
        <div class="row text-center"><h4>{{$product ?? 'محصول'}} : {{number_format($price)}} </h4> </div>
        @endif

        <div class="col-xl-6">
            <input type="range" min="0" max="100" class="form-range" wire:model.live="discount">
        </div>

        <div class="col-xl-1">{{$discount ?? 0}} %</div>

            @if(!$multiple && !$grouped)
            <div class="col-xl-3">{{number_format($price - ($price * ($discount/100)))  ?? 0}} تومان </div>
            @endif

        <div class="col-xl-2 text-start">

            @if($editing)
            <button type="button" class="btn btn-danger" wire:click="cancel"> انصراف </button>
            @endif

            @if($multiple || $grouped)
                    <button type="button" class="btn btn-danger" wire:click="cancelList"> انصراف </button>
            @endif

            <button type="submit" class="cs-button px-4 py-2 border-0 rounded-3"> ذخیره </button>
        </div>

    </form>

    <div class="row">

        <div class="col-xl-1 my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-string-outlined" autocomplete="off" wire:model.live="tab" value="products">
            <label class="btn btn-outline-success w-auto py-2" for="btn-check-string-outlined">محصولات</label>
        </div>

        <div class="col-xxl-1 col-xl-auto my-auto text-center">
            <input type="radio" class="btn-check" id="btn-check-integer-outlined" autocomplete="off" wire:model.live="tab" value="categories">
            <label class="btn btn-outline-primary w-auto py-2" for="btn-check-integer-outlined">گروه ها</label>
        </div>

        @if($tab == 'products')
            <div class="col-xxl-3 col-xl-4 my-auto">
                <input type="text" class="form-control" wire:model.live="search" placeholder="جستجو" autocomplete="off">
            </div>

            <div class="col-xl-1 my-auto">
                <select wire:model.live="perPage" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="">همه</option>
                </select>
            </div>

            <div class="col-xl-2 my-auto">
                <select wire:model.live="sort" class="form-select">
                    <option value="created_at">تاریخ ایجاد</option>
                    <option value="name">نام</option>
                    <option value="fullname">نام کامل</option>
                    <option value="price"> قیمت </option>
                    <option value="discount"> تخفیف </option>
                    <option value="brand_id">نام برند</option>
                    <option value="brand_name">نام کامل برند</option>
                </select>
            </div>

            <div class="col-xl-2 my-auto my-auto">
                <select class="form-select" wire:model.live="direction">
                    <option value="desc">نزولی</option>
                    <option value="asc">صعودی</option>
                </select>
            </div>
        @else
            <div class="col-xl-7 my-auto"></div>
        @endif



        <div class="col-xl-1 px-0 text-end my-auto">
            @if(count($selectedProducts) > 1)
            <button class="btn btn-sm btn-primary rounded-3" wire:click="multipleDiscount"> تخفیف ها </button>
            @endif

            @if(count($selectedCategories) > 1)
                <button class="btn btn-sm btn-primary rounded-3" wire:click="SelectedCategoryDiscount"> تخفیف ها </button>
            @endif
        </div>

        <div class="col-xl-1 px-0 text-end my-auto">
            @if(count($selectedProducts) > 1)
                <button class="btn btn-sm btn-danger rounded-3" wire:click="multipleRemove"> بازنشانی </button>
            @endif

            @if(count($selectedCategories) > 1)
                 <button class="btn btn-sm btn-danger rounded-3" wire:click="removeSelectedCategoryDiscount"> بازنشانی </button>
            @endif
        </div>

    </div>

    <div class="row">

        @if($tab && $tab == 'products')
            @if($this->Products->isNotEmpty())

                @foreach($this->Products as $product)

                    <div class="row border-bottom my-3 py-2">

                        <div class="col-xl-1 my-auto text-center"> <input type="checkbox" value="{{$product->id}}" wire:model.live="selectedProducts"> </div>

                        <div class="col-xl-1 my-auto text-end"> {{$counter++}} </div>

                        <div class="col-xl-1 px-0 text-center my-auto">
                            <img src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش" height="64" class="rounded">
                        </div>

                        <div class="col-xl-2 my-auto text-center"> {{$product->name}} </div>

                        <div class="col-xl-2 my-auto text-center">
                            @if($product->category->parent_id == 0)

                                {{$product->category->name}}

                            @else
                                {{ $product->category->parent->name}}
                                {{$product->category->name}}

                            @endif
                        </div>

                        <div class="col-xl-1 my-auto text-center">{{number_format($product->price)}} تومان</div>

                        <div class="col-xl-1 my-auto text-center">{{$product->discount ?? 0 }} %</div>

                        <div class="col-xl-1 my-auto text-center">

                            @if($product->discount)
                                {{number_format($product->price - ($product->price * ($product->discount/100)) )}}
                                تومان
                            @else
                                {{number_format($product->price)}}
                                تومان
                            @endif

                        </div>

                        <div class="col-xl-1 my-auto text-center">
                            <button class="btn btn-sm btn-primary rounded-3" wire:click="setDiscount({{$product->id}})"> تخفیف </button>
                        </div>

                        <div class="col-xl-1 my-auto text-center">
                            @if($product->discount)
                                <button class="btn btn-sm btn-danger rounded-3" wire:click="removeDiscount({{$product->id}})">
                                   بازنشانی
                                </button>
                            @else
                                <button class="btn btn-sm btn-danger rounded-3" disabled>
                                    بازنشانی
                                </button>
                            @endif
                        </div>

                    </div>

                @endforeach

            @else

                <div class="row border rounded-3 mt-5 text-center py-3"> <h2 class="text-danger"> محصولی ثبت نشده است </h2> </div>

            @endif

            {{$this->Products->links(data:['scrollTo',false])}}

        @else
                                                                            {{--        Category Discount        --}}
            @forelse($this->categories as $category)

                <div class="row">

                    @if($category->parent_id == 0)
                        @if($category->children->isNotEmpty() && $category->has_price)
                            <div class="row border border-primary rounded-4 my-4">

                            <div class="col-xl-2 my-3 text-end text-primary h4"> {{$category->name}} </div>
                            <div class="col-xl-7 my-3"></div>

                                <div class="col-xl-1 my-3 text-start">
                                    <button class="btn btn-sm btn-primary rounded-3" wire:click="categoryDiscount({{$category->id}})"> تخفیف </button>
                                </div>

                                <div class="col-xl-1 my-3 text-start">
                                    <button class="btn btn-sm btn-danger rounded-3" wire:click="removeCategoryDiscount({{$category->id}})">
                                        بازنشانی
                                    </button>
                                </div>

                            <div class="col-xl-1 my-3 text-start my-auto"> <input type="checkbox" value="{{$category->id}}" wire:model.live="selectedCategories"> </div>
                                <hr>

                                @foreach($category->children as $child)
                                    @if($child->has_price)
                                        <div class="col-xl-2 my-3 text-end"> {{$child->name}} </div>
                                        <div class="col-xl-7 my-3"></div>

                                        <div class="col-xl-1 my-3 text-start">
                                            <button class="btn btn-sm btn-primary rounded-3" wire:click="categoryDiscount({{$child->id}})"> تخفیف </button>
                                        </div>

                                        <div class="col-xl-1 my-3 text-start">
                                            <button class="btn btn-sm btn-danger rounded-3" wire:click="removeCategoryDiscount({{$child->id}})">
                                                بازنشانی
                                            </button>
                                        </div>

                                        <div class="col-xl-1 text-start my-auto"><input type="checkbox" value="{{$child->id}}" wire:model.live="selectedCategories"> </div>
                                    @endif


                                @endforeach

                            </div>

                        @else

                            @if($category->has_price)
                                <div class="row border border-primary rounded-4 my-4">

                                    <div class="col-xl-2 my-3 text-end text-primary h4"> {{$category->name}} </div>
                                    <div class="col-xl-2 my-3"></div>
                                    <div class="col-xl-5"></div>

                                    <div class="col-xl-1 my-3 text-start">
                                        <button class="btn btn-sm btn-primary rounded-3" wire:click="categoryDiscount({{$category->id}})"> تخفیف </button>
                                    </div>

                                    <div class="col-xl-1 my-3 text-start">
                                        <button class="btn btn-sm btn-danger rounded-3" wire:click="removeCategoryDiscount({{$category->id}})">
                                            بازنشانی
                                        </button>
                                    </div>


                                    <div class="col-xl-1 my-3 text-start my-auto"><input type="checkbox" value="{{$category->id}}" wire:model.live="selectedCategories"> </div>

                                </div>
                            @endif

                       @endif

                    @endif



                </div>

            @empty
                <div class="row text-center h3">دسته ای ثبت نشده است</div>
            @endforelse


        @endif



    </div>

</div>

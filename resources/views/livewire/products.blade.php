<div class="container-fluid">

    {{--  Showing & selecting categories  --}}

        <div class="row text-center px-xl-5 px-4">

            <h2 class="my-auto"> دسته ها </h2>
            <div class="row text-center border rounded-4 px-xl-5 pt-3 pb-2 mx-auto">

                @if($categories->isNotEmpty())

                    @if(!empty($activeCategory) && count($activeCategory) !== count($categories))

                        <button class="col-12 btn btn-outline-danger rounded-4 fw-bold mx-auto" wire:click="categoryReset"> همه </button>

                    @else
                        <button class="col-12 btn btn-danger rounded-4 fw-bold"> همه </button>
                    @endif

                    @foreach($categories as $cat)

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

            <div class="row text-center">
                @if($activeCategory)
                    <h3>
                    @foreach($activeFilter as $active)
                     {{$active}}
                    @endforeach
                </h3>
                @endif
            </div>

            <div class="col-lg-2 border home-blocks rounded-end-4 mt-3">

                @if($activeCategory)
                    @if($filters->isNotEmpty())
                        @foreach($filters as $filter)

                            <div class="row m-2 text-end border-bottom">
                                <h5>{{$filter->title}}</h5>

                                @if($filter->units->isNotEmpty())
                                    @foreach($filter->units as $unit)

                                        @foreach($unit->values as $value)

                                            <div class="row">
                                                <div class="col-xl-8 text-end">
                                                    {{$value->value}}
                                                    @if($value->suffix)
                                                        {{$value->suffix}}
                                                    @endif
                                                </div>

                                                <div class="col-xl-4 text-start">
                                                    <input type="{{$filter->type}}" wire:model.live="activeFilter" value="{{$value->id}}">
                                                </div>
                                            </div>

                                            <br>
                                        @endforeach
                                    @endforeach
                                @endif

                            </div>
                        @endforeach
                    @endif
                @else

                @endif



            </div>

            <div class="col-lg-10 border home-blocks rounded-start-4 mt-3 px-4">

                @if(!$activeCategory)

                    <div class="row text-center mt-3">
                    @foreach($categories as $category)

                        @if($category->products->isNotEmpty())


                            @foreach($category->products as $product)


                                <a href="{{ route('product.show',$product->id) }}" class="col-xl-2 col-md-4 pt-3 mx-auto delete-badge text-decoration-none">

                                    <div class="side-img text-center overflow-hidden border bg-white pb-3 rounded-top-4" style="height: 80%">
                                    <img class="rounded-4 mt-1" src="{{asset('storage/products/'.$product->image) }}" alt="پیش نمایش">

                                    <div class="row mt-3 mb-2"> <h3 style="color:#84919e"> {{$product->name}} </h3> </div>

                                    </div>

                                    <div class="cs-navbar row my-auto mx-auto py-2 text-center border rounded-bottom-4" dir="rtl">
                                        <h4>
                                            {{number_format(1000000)}}
                                            تومان
                                        </h4>
                                    </div>

                                </a>

                            @endforeach


                        @endif

                    @endforeach
                    </div>
                @else
                    @if($maincat->isNotEmpty())
                        <div class="row text-center mt-3">
                        @foreach($maincat as $category)

                            @if($category->products->isNotEmpty())


                                @foreach($category->products as $product)

                                        <a href="{{ route('product.show',$product->id) }}" class="col-xl-2 col-md-4 pt-3 mx-auto text-decoration-none">

                                            <div class="side-img text-center overflow-hidden border bg-white pb-3 rounded-top-4" style="height: 80%">
                                                <img class="rounded-4 mt-1" src="{{asset('storage/products/'.$product->image) }}" alt="پیش نمایش">

                                                <div class="row mt-3 mb-2"> <h3 style="color:#84919e"> {{$product->name}} </h3> </div>

                                            </div>

                                            <div class="cs-navbar row my-auto mx-auto py-2 text-center border rounded-bottom-4" dir="rtl">
                                                <h5>
                                                    برای استعلام قیمت تماس بگیرید
                                                </h5>
                                            </div>

                                        </a>

                                @endforeach



                                @foreach($category->children as $child)

                                    @if($child->products->isNotEmpty())

                                        @foreach($child->products as $subproduct)

                                                <a href="{{route('product.show',$subproduct->id)}}" class="col-xl-2 col-md-4 pt-3 mx-auto text-decoration-none">

                                                    <div class="side-img text-center overflow-hidden border bg-white pb-3 rounded-top-4" style="height: 80%">
                                                        <img class="rounded-4 mt-1" src="{{asset('storage/products/'.$subproduct->image) }}" alt="پیش نمایش">

                                                        <div class="row mt-3 mb-2"> <h3 style="color:#84919e"> {{$subproduct->name}} </h3> </div>

                                                    </div>

                                                    <div class="cs-navbar row my-auto mx-auto py-2 text-center border rounded-bottom-4" dir="rtl">
                                                        <h5>
                                                            {{number_format(1000000)}}
                                                            تومان
                                                        </h5>
                                                    </div>

                                                </a>
                                        @endforeach

                                    @endif

                                @endforeach

                            @endif

                        @endforeach


                    @endif
                    </div>
                @endif




            </div>

        </div>


    {{--  Showing & selecting products --}}




</div>

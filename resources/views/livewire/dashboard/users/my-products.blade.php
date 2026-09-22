<div class="container-fluid">

    <div class="row text-center">
        <h2> محصولات ذخیره شده </h2>
    </div>

    <div class="row d-none d-xl-flex">
    @forelse($this->MyProducts as $product)

        <div class="row my-2 border rounded-5">

            <div class="col-auto my-auto text-center">
                {{$count++}}
            </div>

            <div class="col-2 my-auto text-center border-end">
                <img src="{{asset('storage/products/'.$product->image) }}" height="85"  alt="پیش نمایش" class="rounded my-2">
            </div>

            <div class="col-6 my-auto text-center h4">
                {{$product->name}}
            </div>

            <div class="col-2 my-auto text-center h4 text-success">
                {{number_format($product->price)}} تومان
            </div>

            <div class="col-auto flex-fill"></div>

            <div class="col-1 my-auto text-start">
                <button class="btn btn-outline-danger w-auto rounded-4" wire:click="deMark({{$product->id}})"> حذف </button>
            </div>

        </div>



    @empty
        <div class="row text-center text-danger">
            <h4> محصولی هیچ محصولی را در پروفایل خود ذخیره نکرده اید  </h4>
        </div>
    @endforelse
</div>


    <div class="row d-xl-none px-sm-2 border">
        @forelse($this->MyProducts as $product)


            <div class="col-lg-4 col-md-5 col-10 my-2 px-md-4 pb-0 my-3 mx-auto">

                <div class="row text-center">
                    <div class="w-100 menu-image rounded-top-5 px-0">
                        <img src="{{asset('storage/products/'.$product->image) }}" alt="پیش نمایش" class="mx-0">
                    </div>
                </div>

                <div class="row text-center cs-navbar d-flex rounded-bottom-5">

                    <div class="col-auto text-center my-auto h5 product-title mx-auto">{{$product->name}}</div>

                    @if($product->supply)
                        @if($product->price)
                            <div class="col-auto text-center bg-success rounded mx-auto my-2 h5">
                                {{number_format($product->price)}} تومان
                            </div>
                        @else
                            <div class="col-auto text-center bg-primary rounded mx-auto my-2 h5">
                                استعلام بگیرید
                            </div>
                        @endif

                    @else
                        <div class="col-auto text-center bg-danger rounded mx-auto my-2 h5">
                            ناموجود
                        </div>
                    @endif




                    <button class="btn btn-danger w-100 rounded-bottom-5 rounded-top-0 mb-0 mx-auto">
                        حذف
                    </button>


                </div>

            </div>


        @empty
            <div class="row text-center text-danger">
                <h4> محصولی هیچ محصولی را در پروفایل خود ذخیره نکرده اید  </h4>
            </div>
        @endforelse
    </div>

</div>

<div class="container">

    <div class="row"><h2> تخفیف محصولات </h2></div>

    <div class="row">
        @foreach($products as $product)

            <div class="row border rounded-3 my-3 py-2">
                <div class="col-xl-1 my-auto text-center"> <input type="checkbox" value="{{$product->id}}" wire:model.live="selected"> </div>
                <div class="col-xl-1 my-auto text-center"> {{$counter++}} </div>
                <div class="col-xl-1 my-auto text-center side-img2"> <img src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش" height="100" class="rounded"> </div>

                <div class="col-xl-1 my-auto text-center"> {{$product->name}} </div>
                <div class="col-xl-1 my-auto text-center"> {{$product->fullname}} </div>
                <div class="col-xl-1 my-auto text-center">{{$product->price}}</div>

                <div class="col-xl-1 my-auto text-center"> {{$product->brand->name ?? $product->brand_name ?? 'فاقد برند'}} </div>

            </div>

        @endforeach



        @else

            <div class="row border rounded-3 mt-5 text-center py-3"><h2 class="text-danger"> محصولی ثبت نشده است </h2></div>

        @endif
    </div>

</div>

<div class="container">

    <div class="row text-center">
        <h2> محصولات ذخیره شده </h2>
    </div>

    @forelse($this->MyProducts as $product)

        <div class="row my-2 border rounded-5 d-flex">

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

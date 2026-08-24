<div class="container">

    <div class="row">
        <div class="col-xl-2 text-center side-img2">
            <img class="mx-auto social-icon rounded p-2" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">
        </div>

        <div class="col-xl-2 text-center d-flex my-auto h2">
            {{$product->name}}
        </div>
    </div>

    <livewire:dashboard.attachments.details.table :activeTable="$activeTable" :product="$product"/>

</div>

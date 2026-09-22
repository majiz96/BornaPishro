<div class="row text-center">
    <h2 class="my-3">{{$name}}  {{$lastname}}</h2>

    <h1 class="my-3" wire:text="message"></h1>

{{--    <div class="row border border-danger border-3 home-tile mx-auto"></div>--}}

<div class="row text-center mx-auto">

    <form wire:submit.prevent="save">

        @csrf

        <div class="col-xl-6 col-lg-12 col-12 border border-2 rounded-5 mx-auto">

            <div class="row my-3 px-lg-0 px-2">

                <input type="hidden" wire:model.blur="position_id">

                <div class="col-xl-auto col-lg-auto text-xl-end pe-lg-3 text-lg-start text-end pe-lg-0 pe-4 my-lg-2 mx-lg-auto"><label for="name">نام :</label></div>
                <div class="col-xxl-7 col-xl-8 col-lg-10 col-12 my-lg-1 mx-auto"><input type="text" id="name" class="input-group-text w-100 text-end rounded-3" wire:model.blur="name"></div>
                <div class="text-danger my-1">@error('name') {{ $message }} @enderror</div>

                <div class="col-xl-auto col-lg-auto text-xl-end pe-lg-3 text-lg-start text-end pe-lg-0 pe-4 my-lg-2 mx-auto"><label for="lastname">نام خانوادگی :</label></div>
                <div class="col-xxl-7 col-xl-8 col-lg-10 my-lg-1 mx-auto"><input type="text" id="lastname" class="input-group-text w-100 text-end rounded-3" wire:model.blur="lastname"></div>
                <div class="text-danger my-1">@error('lastname') {{ $message }} @enderror</div>

                <div class="col-xl-auto col-lg-auto text-xl-end pe-lg-3 text-lg-start text-end pe-lg-0 pe-4 my-lg-2 mx-auto"><label for="email">ایمیل :</label></div>
                <div class="col-xxl-7 col-xl-8 col-lg-10 my-lg-1 mx-auto"><input type="text" id="email" class="input-group-text w-100 text-end rounded-3" wire:model.blur="email"></div>
                <div class="text-danger my-1">@error('email') {{ $message }} @enderror</div>

                <div class="col-xl-auto col-lg-auto text-xl-end pe-lg-3 text-lg-start text-end pe-lg-0 pe-4 my-lg-2 mx-auto"><label for="password">رمز عبور :</label></div>
                <div class="col-xxl-7 col-xl-8 col-lg-10 my-lg-1 mx-auto"><input type="text" id="password" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password"></div>
                <div class="text-danger my-1">@error('password') {{ $message }} @enderror</div>

                <div class="col-xl-auto col-lg-auto text-xl-end pe-lg-3 text-lg-start text-end pe-lg-0 pe-4 my-lg-2 mx-auto"><label for="password_confirmation">تایید رمز عبور :</label></div>
                <div class="col-xxl-7 col-xl-8 col-lg-10 my-lg-1 mx-auto"><input type="text" id="password_confirmation" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password_confirmation"></div>
                <div class="text-danger my-1">@error('password_confirmation') {{ $message }} @enderror</div>

                <div class="row my-2">
                    <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> ویرایش </button>
                </div>

            </div>

        </div>

    </form>

</div>

</div>

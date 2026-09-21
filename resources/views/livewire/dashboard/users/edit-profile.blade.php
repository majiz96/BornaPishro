<div class="row text-center">
    <h2 class="my-3">{{$name}}  {{$lastname}}</h2>

    <h1 class="my-3" wire:text="message"></h1>

<div class="row text-center">

    <form wire:submit.prevent="save">

        @csrf

        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 border border-2 rounded-5 mx-auto">

            <div class="row my-5 justify-content-center">

                <input type="hidden" wire:model.blur="position_id">

                <div class="col-xxl-auto col-lg-4 text-lg-start my-lg-2 mx-auto"><label for="name">نام :</label></div>
                <div class="col-xxl-7 col-lg-6 my-lg-1 mx-auto"><input type="text" id="name" class="input-group-text w-100 text-end rounded-3" wire:model.blur="name"></div>
                <div class="text-danger my-1">@error('name') {{ $message }} @enderror</div>

                <div class="col-xxl-auto col-lg-4 text-lg-start my-lg-2 mx-auto"><label for="lastname">نام خانوادگی :</label></div>
                <div class="col-xxl-7 col-lg-6 my-lg-1 mx-auto"><input type="text" id="lastname" class="input-group-text w-100 text-end rounded-3" wire:model.blur="lastname"></div>
                <div class="text-danger my-1">@error('lastname') {{ $message }} @enderror</div>

                <div class="col-xxl-auto col-lg-4 text-lg-start my-lg-2 mx-auto"><label for="email">ایمیل :</label></div>
                <div class="col-xxl-7 col-lg-6 my-lg-1 mx-auto"><input type="text" id="email" class="input-group-text w-100 text-end rounded-3" wire:model.blur="email"></div>
                <div class="text-danger my-1">@error('email') {{ $message }} @enderror</div>

                <div class="col-xxl-auto col-lg-4 text-lg-start my-lg-2 mx-auto"><label for="password">رمز عبور :</label></div>
                <div class="col-xxl-7 col-lg-6 my-lg-1 mx-auto"><input type="text" id="password" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password"></div>
                <div class="text-danger my-1">@error('password') {{ $message }} @enderror</div>

                <div class="col-xxl-auto col-lg-4 text-lg-start my-lg-2 mx-auto"><label for="password_confirmation">تایید رمز عبور :</label></div>
                <div class="col-xxl-7 col-lg-6 my-lg-1 mx-auto"><input type="text" id="password_confirmation" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password_confirmation"></div>
                <div class="text-danger my-1">@error('password_confirmation') {{ $message }} @enderror</div>

                <div class="row">
                    <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> ویرایش </button>
                </div>

            </div>

        </div>

    </form>

</div>

</div>

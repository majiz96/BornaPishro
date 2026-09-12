<div class="container-fluid text-center align-content-center">

        <div class="row text-center">

            <form wire:submit.prevent="register">

                <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-6 border border-2 rounded-5 mx-auto">
                <div class="row my-5 px-2">


                    <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="name">نام :</label></div>
                    <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="name" class="input-group-text w-100 text-end rounded-3" wire:model.blur="name"></div>
                    <div class="text-danger my-1">@error('name') {{ $message }} @enderror</div>

                    <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="lastname">نام خانوادگی :</label></div>
                    <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="lastname" class="input-group-text w-100 text-end rounded-3" wire:model.blur="lastname"></div>
                    <div class="text-danger my-1">@error('lastname') {{ $message }} @enderror</div>

                    <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="email">ایمیل :</label></div>
                    <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="email" class="input-group-text w-100 text-end rounded-3" wire:model.blur="email"></div>
                    <div class="text-danger my-1">@error('email') {{ $message }} @enderror</div>

                    <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="password">رمز عبور :</label></div>

                    <div class="col-xxl-7 col-lg-6 my-lg-1 position-relative">
                        <input type="{{ $showPassword == false ? 'password' : 'text' }}" id="password" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password">

                        <i
                            wire:click="togglePassword"
                            class="bi {{ $showPassword ? 'bi-eye-slash' : 'bi-eye' }}
                            position-absolute top-50 start-0 translate-middle-y ms-4"
                            style="cursor: pointer;"
                        ></i>

                    </div>
                    <div class="text-danger my-1">@error('password') {{ $message }} @enderror</div>

                    <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="password_confirmation">تایید رمز عبور :</label></div>

                    <div class="col-xxl-7 col-lg-6 my-lg-1 position-relative">
                        <input type="{{ $showPassword == false ? 'password' : 'text' }}" id="password_confirmation" class="input-group-text w-100 text-end rounded-3"
                               wire:model.blur="password_confirmation">

                        <i
                            wire:click="togglePassword"
                            class="bi {{ $showPassword ? 'bi-eye-slash' : 'bi-eye' }}
                            position-absolute top-50 start-0 translate-middle-y ms-4"
                            style="cursor: pointer;"
                        ></i>

                    </div>

                    </div>
                    <div class="text-danger my-1">@error('password_confirmation') {{ $message }} @enderror</div>

                    <div class="row mb-3">
                    <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> ثبت نام </button>
                    </div>

                    </div>

                </div>

            </form>

        </div>

</div>

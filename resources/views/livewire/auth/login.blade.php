<div class="container-fluid text-center align-content-center">

        <div class="row text-center">

            <form wire:submit.prevent="login">

                <div class="col-xxl-3 col-lg-8 col-md-8 border border-2 rounded-5 mx-auto my-5">
                    <div class="row my-3 px-2">

                        <div class="col-xl-3 col-lg-4 my-lg-2 text-xl-center text-end px-4"><label for="email">ایمیل :</label></div>
                        <div class="col-xl-8 col-lg-6 my-lg-1"><input type="text" id="email" class="input-group-text w-100 text-end rounded-3" wire:model.blur="email"></div>
                        <div class="text-danger my-1">@error('email') {{ $message }} @enderror</div>

                        <div class="col-xl-3 col-lg-4 my-lg-2 text-xl-center text-end px-4"><label for="password">رمز عبور :</label></div>
                        <div class="col-xl-8 col-lg-6 my-lg-1 position-relative">
                            <input type="{{ $showPassword == false ? 'password' : 'text' }}" id="password" class="input-group-text w-100 text-end rounded-3" wire:model.blur="password">

                            <i
                                wire:click="togglePassword"
                                class="bi {{ $showPassword ? 'bi-eye-slash' : 'bi-eye' }}
                            position-absolute top-50 start-0 translate-middle-y ms-4"
                                style="cursor: pointer;"
                            ></i>

                        </div>
                        <div class="text-danger my-1">@error('password') {{ $message }} @enderror</div>

                        <div class="col-xxl-3 col-xl-4 col-sm-4 col-5 my-lg-3 ms-0 text-xxl-start text-xl-center"><label for="remember" class="text-end">فراموش نکن</label></div>
                        <div class="col-xxl-9 col-xl-8 col-sm-8 col-7 my-auto px-0 text-end"><input type="checkbox" id="remember" class="" wire:model.blur="remember"></div>




                        <div class="row">
                            <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> ورود </button>
                        </div class="text-danger">

                    </div>

                </div>

            </form>

        </div>

</div>

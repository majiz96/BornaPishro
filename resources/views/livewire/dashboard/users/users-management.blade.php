<div class="container-fluid">

    <h2 class="text-center my-3" wire:text="title"></h2>

    <div class="row text-center">

        <form wire:submit.prevent="save">

            @csrf

            <div class="col-xxl-4 col-xl-6 border border-2 rounded-5 mx-auto">
                <div class="row my-3 px-2">

                    <select class="col-xxl-7 col-lg-4 text-lg-start my-lg-2 cs-navbar rounded-3 text-center py-1 mx-auto" wire:model.blur="position_id">
                        <option class="text-center bg-body text-body rounded-4"> سطح دسترسی </option>
                        @foreach($this->Positions as $pose)
                            <option class="text-center bg-body text-body rounded-4" value="{{$pose->id}}">{{$pose->title}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger my-1">@error('position_id') {{ $message }} @enderror</div>

                    @if(!$editing)
                        <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="name">نام :</label></div>
                        <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="name" class="input-group-text w-100 text-end" wire:model.blur="name"></div>
                        <div class="text-danger my-1">@error('name') {{ $message }} @enderror</div>

                        <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="lastname">نام خانوادگی :</label></div>
                        <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="lastname" class="input-group-text w-100 text-end" wire:model.blur="lastname"></div>
                        <div class="text-danger my-1">@error('lastname') {{ $message }} @enderror</div>

                        <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="email">ایمیل :</label></div>
                        <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="email" class="input-group-text w-100 text-end" wire:model.blur="email"></div>
                        <div class="text-danger my-1">@error('email') {{ $message }} @enderror</div>

                        <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="password">رمز عبور :</label></div>
                        <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="password" class="input-group-text w-100 text-end" wire:model.blur="password"></div>
                        <div class="text-danger my-1">@error('password') {{ $message }} @enderror</div>

                        <div class="col-xxl-3 col-lg-4 text-lg-start my-lg-2"><label for="password_confirmation">تایید رمز عبور :</label></div>
                        <div class="col-xxl-7 col-lg-6 my-lg-1"><input type="text" id="password_confirmation" class="input-group-text w-100 text-end" wire:model.blur="password_confirmation"></div>
                        <div class="text-danger my-1">@error('password_confirmation') {{ $message }} @enderror</div>
                    @endif

                    @if($editing)
                        <div class="row">
                            <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> {{$editing ? 'تغییر سطح دسترسی' : 'افزودن'}} </button>
                            <button type="button" class="btn btn-danger rounded-4 py-2 px-4 w-auto mx-auto" wire:click="cancel"> انصراف </button>
                        </div>
                    @else
                        <div class="row-cols-2">
                            <button type="submit" class="submit-button rounded-4 py-2 px-4 w-auto mx-auto"> {{$editing ? 'تغییر سطح دسترسی' : 'افزودن'}} </button>
                        </div>

                    @endif


                </div>

            </div>

        </form>

    </div>

    <div class="row my-5 mx-auto">

        <div class="row my-3 px-5">

            <div class="col-xl-3">
                <input type="text" class="form-control" placeholder="جستجو..." wire:model.live="search">
            </div>

            <div class="col-xl-2 my-auto">
                <select wire:model.live="sort" class="form-select">
                    <option value="created_at">تاریخ ثبت نام</option>
                    <option value="email_verified_at">تاریخ تایید اکانت</option>
                    <option value="name">نام</option>
                    <option value="lastname">نام خانوادگی</option>
                    <option value="email">ایمیل</option>
                    <option value="position_id">جایگاه</option>
                </select>
            </div>

            <div class="col-xl-2 my-auto">
                <select wire:model.live="direction" class="form-select">
                    <option value="desc">نزولی</option>
                    <option value="asc">صعودی</option>
                </select>
            </div>

            <div class="col-xxl-1 col-xl-2 my-auto">
                <select wire:model.live="perPage" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="">همه</option>
                </select>
            </div>

        </div>

        @if($this->Users->isNotEmpty())

            <div class="row mx-auto py-2 px-5 mx-3 rounded-4">

                <div class="col-1 text-center mx-auto">
                    <input class="my-2" type="checkbox" wire:model.live="selectAll">
                    @if($selectAll || count($selected) > 1)
                        <button class="btn btn-sm btn-danger" wire:click="selectedDelete" wire:confirm="آیا از حذف کاربران انتخاب شده مطمئن هستید؟"> حذف همه </button>
                    @endif

                </div>

                <div class="col-1 text-center mx-auto h5"> ردیف </div>

                <div class="col-1 text-center mx-auto h5">نام</div>

                <div class="col-2 text-center mx-auto h5">نام خانوادگی</div>

                <div class="col-3 text-center mx-auto h5">ایمیل</div>

                <div class="col-1 text-center mx-auto h5">عنوان</div>

                <div class="col-1 text-center mx-auto h5">حذف</div>
                <div class="col-1 text-center mx-auto h5">ویرایش</div>

            </div>
            @foreach($this->Users as $user)




                    <div class="row border-bottom mx-auto py-3 my-3 px-5 mx-3">

                        <div class="col-1 text-center mx-auto"><input class="my-2" type="checkbox" value="{{$user->id}}" wire:model.live="selected"> </div>

                        <div class="col-1 text-center mx-auto"> {{$counter++}} </div>

                        <div class="col-1 text-center mx-auto">{{$user->name}}</div>

                        <div class="col-2 text-center mx-auto">{{$user->lastname}}</div>

                        <div class="col-3 text-center mx-auto">{{$user->email}}</div>

                        <div class="col-1 text-center mx-auto"> {{ $user->position->title ?? 'کاربر'}}
                        </div>

                        <div class="col-1 text-center mx-auto"><button class="btn btn-sm btn-danger" wire:click="delete({{$user->id}})" wire:confirm="آیا از حذف (( {{$user->name}}  {{$user->lastname}} )) مطمئن هستید؟">حذف</button></div>
                        <div class="col-1 text-center mx-auto"><button class="btn btn-sm btn-primary" wire:click="edit({{$user->id}})">ویرایش</button></div>

                    </div>

            @endforeach

        @else
            <div class="row mx-auto py-2 px-5 mx-3 rounded-4 text-center"><h2 class="text-danger">کاربری یافت نشد</h2></div>
        @endif

        @if($perPage !== "")
            {{$this->Users->links(data:['scrollTo',false])}}
        @endif



    </div>

</div>

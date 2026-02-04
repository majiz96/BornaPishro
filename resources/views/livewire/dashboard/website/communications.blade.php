<div class="container-fluid">

    @include('modals.see-files')

    <div class="row text-center">
        <h1 class="my-4"> ارتباطات </h1>
    </div>

    <div class="row mt-3 border rounded-5 p-3">

        @if($comm->isNotEmpty())

            <div class="row my-2">

                <div class="col-xl-3">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="جستجو..." autocomplete="off">
                </div>

                <div class="col-xl-1 my-auto">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="">همه</option>
                    </select>
                </div>

                <div class="col-xl-1 my-auto">
                    <select class="form-select" wire:model.live="sort">
                        <option value="created_at">تاریخ</option>
                        <option value="name">نام</option>
                        <option value="subject">موضوع</option>
                        <option value="email">ایمیل</option>
                        <option value="phone">شماره همراه</option>
                    </select>
                </div>

                <div class="col-xl-1 my-auto">
                    <select class="form-select" wire:model.live="direction">
                        <option value="desc">نزولی</option>
                        <option value="asc">صعودی</option>
                    </select>
                </div>

            </div>

            <div class="row cs-navbar border rounded-4 py-1 mx-auto">

                <div class="col-xl-1 text-center py-2"><input type="checkbox" wire:model.live="selectAll"></div>

                <div class="col-xl-1 text-center py-2">ردیف</div>
                <div class="col-xl-3 text-center py-2"> عنوان</div>
                <div class="col-xl-1 text-center py-2"> نام و نام خانوادگی</div>
                <div class="col-xl-2 text-center py-2"> ایمیل</div>
                <div class="col-xl-1 text-center py-2"> شماره همراه</div>
                <div class="col-xl-1 text-center py-2">مشاهده</div>
                <div class="col-xl-1 text-center py-2">فایلها</div>

                <div class="col-xl-1 text-center py-2">

                    @if(count($selected) > 1)
                        <button class="btn btn-sm btn-danger rounded-3" wire:click="selectedDelete"
                                wire:confirm="آیا از حذف کاربران انتخاب شده مطمئن هستید؟"> حذف همه
                        </button>
                    @else
                        حذف
                    @endif

                </div>

            </div>


            @foreach($comm as $com)
                <div class="row mx-auto border rounded-4 my-3">

                    <div class="col-xl-1 text-center pt-2"><input type="checkbox" value="{{$com->id}}"
                                                                  wire:model.live="selected"></div>
                    <div class="col-xl-1 text-center pt-2">{{$row++}}</div>
                    <div class="col-xl-3 text-center pt-2"> {{$com->subject}} </div>

                    <div
                        class="col-xl-1 text-center pt-2"> {{ $com->name !== null ? $com->name : $com->user->name .' '. $com->user->lastname }} </div>
                    <div
                        class="col-xl-2 text-center pt-2"> {{ $com->email !== null ? $com->email : $com->user->email }} </div>

                    <div class="col-xl-1 text-center pt-2"
                         dir="ltr"> {{ $com->phone !== null ? $com->phone : '' }} </div>

                    <div class="col-xl-1 text-center py-1">
                        <span class="btn btn-link text-decoration-none text-success fw-bold"
                              wire:click="seeMessage({{$com->id}})"> مشاهده </span>
                    </div>

                    <div class="col-xl-1 text-center py-1">

                        @if(count($com->files) > 0)

                            <span class="btn btn-link text-decoration-none text-primary fw-bold"
                                  wire:click="seeFiles({{$com->id}})"> فایلها </span>
                            <span class="small px-1 rounded-5 bg-primary text-light"> {{count($com->files)}} </span>
                        @endif

                    </div>

                    <div class="col-xl-1 text-center py-1">
                        <span class="btn btn-link text-decoration-none text-danger fw-bold"
                              wire:click="delete({{$com->id}})"
                              wire:confirm="آیا از حذف پیام ({{$com->subject}}) مطمئن هستید؟"> حذف </span>
                    </div>


                </div>

                @include('modals.see-message')

            @endforeach
        @else
            <div class="row text-center">
                <h2 class="my-4 text-danger"> هیچ پیامی ارسال نشده است </h2>
            </div>
        @endif

        @if($perPage !== "")
        {{$comm->links(data:['scrollTo',false])}}
        @endif


    </div>


</div>

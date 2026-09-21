<div class="container-fluid overflow-x-hidden">


    @if($panelShow)
        {{--    Message panel    --}}
        <div class="row border text-center mx-3 rounded-5 mt-auto mb-4 py-2 message-panel">


            @auth()
                <form wire:submit.prevent="saveMessage" class="row mx-auto px-0">


                    <div class="col-xl-6 mx-auto">

                        <div class="row my-4 mx-auto">

                            <div class="col-xl-1"><label class="form-label" for="subject"> موضوع </label></div>
                            <div class="col-xl-11"><input type="text" class="form-control" id="subject" wire:model.blur="subject"></div>
                            @error('subject')<div class="text-danger">{{$message}}</div>@enderror

                        </div>

                        <div class="row mx-auto">
                            <div class="col-xl-12">
                                <textarea rows="5" class="form-control h-auto" wire:model.live="text"></textarea>
                                @error('text')<div class="text-danger">{{$message}}</div>@enderror
                                <small class="row pe-3 text-end" id="textcount" wire:ignore></small>
                            </div>
                        </div>

                        <div class="row my-4 px-lg-4">

                            <div class="col-xl-2 text-xl-end">

                                <input type="file" id="files" wire:model="files" class="d-none" multiple>
                                <label for="files" class="btn btn-primary my-xl-0 my-4"> <i class="bi-upload"></i> </label>

                            </div>

                            <div class="col-xl-8 text-xl-end">
                                <label class="alert alert-secondary py-1">
                                    @if (count($uploadedFiles))
                                        @foreach ($uploadedFiles as $file)
                                            <span class="badge bg-secondary me-1 m-2">{{ $file }}</span>
                                        @endforeach
                                    @else
                                        {{ $uploadTip }}
                                    @endif
                                </label>
                            </div>

                            <div class="col-xl-2 text-xl-start">
                                <button type="submit" class="cs-button ms-0 w-auto rounded-3 border-0 mx-auto py-2 px-3"> ارسال </button>
                            </div>
                        </div>

                        @error('files.*')
                        <div class="text-danger text-nowrap">{{ $message }}</div>
                        @enderror

                        <div class="text-danger">
                            {{$cooldownMessage}}
                        </div>

                    </div>
                </form>
            @endauth

            {{--  Guest user's  --}}


            @guest()

                <form wire:submit.prevent="saveGuestMessage" class="px-0 mx-auto">

                        <div class="row mx-auto my-4 px-xxl-5 d-xl-flex">

                            <div class="col-xl-auto flex-fill d-xl-block d-none"></div>

                            <div class="col-lg-auto text-xl-center text-end me-2 my-auto"><label class="form-label" for="name"> نام و نام خانوادگی </label></div>
                            <div class="col-xxl-2 col-xl-2 col-lg-3">
                                <input type="text" class="form-control" id="name" wire:model.blur="name">
                            @error('name')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror
                            </div>

                            <div class="col-lg-auto text-xl-start text-end mt-2 me-2"><label class="form-label" for="guest_email"> ایمیل </label></div>
                            <div class="col-xxl-2 col-xl-2 col-lg-3"><input type="email" class="form-control" id="guest_email" wire:model.blur="guest_email">
                            @error('guest_email')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror
                            </div>

                            <div class="col-lg-auto text-xl-start text-end mt-2 me-2"><label class="form-label" for="guest_phone"> شماره همراه </label></div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2"><input type="tel" class="form-control" id="guest_phone" wire:model.blur="guest_phone">
                                @error('guest_phone')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror
                            </div>

                            <div class="col-xl-auto flex-fill d-xl-block d-none"></div>

                        </div>

                        <div class="row my-3 mx-auto px-xxl-5">
                            <div class="col-xl-auto text-xl-start text-end me-2 my-auto"><label class="form-label" for="subject"> موضوع </label></div>
                            <div class="col-xl-11"><input type="text" class="form-control" id="subject" wire:model.blur="subject"></div>
                            @error('subject')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror
                        </div>

                        <div class="row mx-auto px-xxl-5">
                            <div class="col-xl-12">
                                <textarea rows="5" class="form-control h-auto" wire:model.blur="text" style="resize: vertical"></textarea>
                                @error('text')<div class="text-danger">{{$message}}</div>@enderror
                                <small class="row pe-3 text-end" id="textcount" wire:ignore></small>
                            </div>
                        </div>

                        <div class="row mx-auto my-4">

                            <div class="col-xl-2 text-xl-center">

                                <input type="file" id="files" wire:model="files" class="d-none" multiple>
                                <label for="files" class="btn btn-primary my-xl-0 my-4"> <i class="bi-upload"></i> </label>

                            </div>

                            <div class="col-xl-8 text-xl-end">
                                <label class="alert alert-secondary py-1">
                                    @if (count($uploadedFiles))
                                        @foreach ($uploadedFiles as $file)
                                            <span class="badge bg-secondary me-1 m-2">{{ $file }}</span>
                                        @endforeach
                                    @else
                                        {{ $uploadTip }}
                                    @endif
                                </label>
                            </div>

                            <div class="col-xl-2 text-xl-center">
                                <button type="submit" class="cs-button ms-0 w-auto rounded-3 border-0 mx-auto py-2 px-3"> ارسال </button>
                            </div>

                        </div>

                        @error('files.*')
                        <div class="text-danger text-nowrap">{{ $message }}</div>
                        @enderror

                        <div class="text-danger">
                            {{$cooldownMessage}}
                        </div>


                </form>

            @endguest

        </div>
    @endif



        @if(!$hideFooter)
            {{--  Desktop Footer  --}}
            <div class="row cs-navbar rounded-top-5 sticky-bottom d-none d-xl-flex mx-xxl-3 mx-3">

                <div class="col-xxl-5 col-xl-4 pt-3 px-4">

                    <div class="row my-2">
                        <div class="col-auto fw-bold"> تماس : </div>
                        <div class="col-auto"> {{$mobile}} </div>
                        <div class="col-auto"> - </div>
                        <div class="col-auto"> {{$phone}} </div>
                    </div>


                    <div class="row my-2">
                        <div class="col-auto fw-bold">ایمیل :</div>
                        <a href="{{$email}}" class="col-auto text-white text-decoration-none fw-bold font-monospace h5">
                            {{$email}}
                        </a>
                    </div>
                    <div class="row my-2">
                        <div class="col-auto fw-bold"> آدرس : </div>
                        <div class="col-auto">
                            {{$address}}
                        </div>
                    </div>

                    <div class="row h5 my-2"></div>

                    <div class="row h5 my-2"></div>
                </div>


                <div class="col-xl-4 pt-4 text-start">

                    <div class="row my-auto">
                        <div class="col-auto">
                            فعالیت حضوری :
                        </div>
                        <div class="col-auto">
                            {{$activity}}
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-auto">
                            پاسخگویی :
                        </div>
                        <div class="col-auto">
                            {{$response}}
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 pt-3 text-start">

                    @forelse($licenses as $license)
                        <a class="col-auto mx-auto my-2 text-center" href="{{$license->link}}">
                            <img src="{{ asset('storage/license_icons/'.$license->icon) }}">
                        </a>
                    @empty

                    @endforelse

                </div>

                <div class="col-xxl-10 mx-auto pt-3 text-center">
                    {{$about_us}}
                </div>

                <div class="col-xxl-6 pt-3 text-center mx-auto py-2">




                    <div class="row">

                        @if($socials->isNotEmpty())

                            <div class="row text-center"> <h4>با ما همراه باشید</h4> </div>

                            @foreach($socials as $social)
                                <a class="col-auto mx-auto my-2 text-center" href="{{$social->link}}">
                                    <img src="{{ asset('storage/social_icons/'.$social->icon) }}" height="40">
                                </a>
                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

            {{--  Mobile Footer  --}}
            <div class="row cs-navbar d-xl-none d-xxl-none sticky-bottom">

                <div class="col-sm-8 col-12 col-12 pt-3 px-4 mx-auto">

                    <div class="row text-center my-sm-2 my-4">
                        <div class="row">
                            <div class="col-sm-auto mt-sm-0 col-auto fw-bold"> تماس : </div>
                            <div class="col-auto mt-sm-0 mx-auto"> {{$mobile}} </div>
                            <div class="col-auto mt-sm-0 mx-auto"> | </div>
                            <div class="col-auto mt-sm-0 mx-auto"> {{$phone}} </div>
                        </div>
                    </div>


                    <div class="row my-sm-2 my-4">
                        <div class="col-auto fw-bold">ایمیل :</div>
                        <a href="{{$email}}" class="col-auto text-white text-decoration-none fw-bold font-monospace h5">
                            {{$email}}
                        </a>
                    </div>
                    <div class="row my-sm-2 my-4">
                        <div class="col-auto fw-bold"> آدرس : </div>
                        <div class="col-auto">
                            {{$address}}
                        </div>
                    </div>

                    <div class="row my-auto">
                        <div class="col-auto">
                            فعالیت حضوری :
                        </div>
                        <div class="col-auto">
                            {{$activity}}
                        </div>
                    </div>
                    <div class="row my-sm-2 my-4">
                        <div class="col-auto">
                            پاسخگویی :
                        </div>
                        <div class="col-auto">
                            {{$response}}
                        </div>
                    </div>
                </div>


                <div class="col-sm-4 col-12 pt-4 px-0 mx-auto text-center ">

                    <div class="row mx-auto">
                        @forelse($licenses as $license)
                            <a class="col-sm-6 col-4 mx-auto mb-2 text-center  gallery-img" href="{{$license->link}}">
                                <img src="{{ asset('storage/license_icons/'.$license->icon) }}">
                            </a>
                        @empty

                        @endforelse
                    </div>


                </div>



                <div class="row mx-auto pt-3 text-center">
                    {{$about_us}}
                </div>

                <div class="col-xxl-6 pt-3 text-center mx-auto py-2">

                    <div class="row">

                        @if($socials->isNotEmpty())

                            <div class="row text-center"> <h4>با ما همراه باشید</h4> </div>

                            @foreach($socials as $social)
                                <a class="col-auto mx-auto my-2 text-center" href="{{$social->link}}">
                                    <img src="{{ asset('storage/social_icons/'.$social->icon) }}" height="40">
                                </a>
                            @endforeach

                        @endif

                    </div>

                </div>

            </div>
        @endif


</div>

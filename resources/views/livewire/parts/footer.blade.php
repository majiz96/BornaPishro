<div class="container-fluid overflow-x-hidden">


    {{--  Desktop Footer  --}}
    <div class="row cs-navbar rounded-top-5 sticky-bottom d-none d-xl-flex mx-xxl-5 mx-3">

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


            <div class="row text-center"> <h4>با ما همراه باشید</h4> </div>

            <div class="row">

                @forelse($socials as $social)
                    <a class="col-auto mx-auto my-2 text-center" href="{{$social->link}}">
                        <img src="{{ asset('storage/social_icons/'.$social->icon) }}" height="40">
                    </a>
                @empty
                    <div class="col-auto"> در حال حاضر فعالیت مجازی خارج از وبسایت نداریم </div>
                @endforelse

            </div>

        </div>

    </div>

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


            <div class="row text-center"> <h4>با ما همراه باشید</h4> </div>

            <div class="row">

                @forelse($socials as $social)
                    <a class="col-auto mx-auto my-2 text-center" href="{{$social->link}}">
                        <img src="{{ asset('storage/social_icons/'.$social->icon) }}" height="40">
                    </a>
                @empty
                    <div class="col-auto"> در حال حاضر فعالیت مجازی خارج از وبسایت نداریم </div>
                @endforelse

            </div>

        </div>

    </div>

</div>

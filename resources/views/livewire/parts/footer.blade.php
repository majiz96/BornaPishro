<div class="container">

    <div class="row cs-navbar rounded-top-5 sticky-bottom">

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


        <div class="col-xxl-4 pt-4 text-start">

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

        <div class="col-xxl-3 pt-3 text-start">

            @forelse($licenses as $license)
                <a class="col-auto mx-auto my-2 text-center" href="{{$license->link}}">
                    <img src="{{ asset('storage/license_icons/'.$license->icon) }}">
                </a>
            @empty

            @endforelse

        </div>

        <div class="col-xxl-10 mx-auto pt-3 text-center">

            اعضای گروه مهندسی برنا پیشرو تحصیل کرده در رشته های برق و مکانیک هستند
            و هر یک سالها به کسب تجربه در صنعت برق و مکانیک در شرکتهای مختلف معتبر در
            کشور پرداخته اند و بخوبی نسبت به پروژه های صنعتی در این حوزه و اتوماسیون صنعتی شناخت دارند.
            علی رغم تلاش مسولین در بهبود اوضاع صنعت ،اتصال علم و دانشگاه به صنعت همواره
            یکی از حوزه های مغفول در کشور ما بوده .

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

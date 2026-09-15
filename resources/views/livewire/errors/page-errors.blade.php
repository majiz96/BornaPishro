<div class="container avoid-emptiness-tall d-flex text-light">

    <div class="row bg-danger p-2 rounded-4 d-flex mx-md-auto mx-2 my-auto" dir="ltr">

        <div class="col-auto my-auto h1 latin-font">
            <i class="bi-{{$sign}}"></i>
            Error
            {{$status}}
            :
        </div>

        <div class="col-auto flex-fill fw-bolder my-auto text-end">
            {{$message}}
        </div>

        @if($status < 500)
            <a href="/" class="btn cs-button rounded-3"> بازگشت به صفحه اصلی </a>
        @endif

    </div>


</div>

<div class="container-fluid">

    <div class="row px-3">

        <div class="col-xxl-2 col-xl-3 col-lg-4 px-4 py-3">
            @if($messages->isNotEmpty())

                @foreach($messages as $message)

                    <div class="row border text-end py-1 px-2 rounded mt-3">


                        <a href="{{route('messages.show',$message->id)}}" class=" text-{{$message->style}} text-decoration-none" wire:navigate>
                          {{$message->title}}
                        </a>

                    </div>

                @endforeach

            @endif
        </div>

        <div class="col-xxl-9 col-xl-8 col-lg-7 home-tile border rounded-5 mx-auto text-center">

            <div class="row text-center mt-3"><h2> {{$notice->title}} </h2></div>
            <hr>
            <div class="row text-center px-4"><h5> {{$notice->description}} </h5></div>

        </div>


    </div>

</div>

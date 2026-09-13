<div class="container-fluid avoid-emptiness">

    {{--  details of post  --}}

    @if($this->Category->isNotEmpty())



        <div class="row p-2 m-2">

            @foreach($this->Category as $category)


            <div class="col-auto mx-auto">
                <a href="" class="text-body text-decoration-none nav-link"> {{$category->field->name ?? ''}} </a>
            </div>

            <div class="col-auto">/</div>

            <div class="col-auto mx-auto">
                <a href="" class="text-body text-decoration-none nav-link"> {{$category->parent->name ?? ''}} </a>
            </div>

            <div class="col-auto">/</div>

            <div class="col-auto mx-auto">
                <a href="" class="text-body text-decoration-none nav-link">
                    {{$category->name ?? ''}}
                </a>
            </div>
                @endforeach

            <div class="col-xl-8 mx-auto"></div>


            <div class="col-auto text-start mx-auto">
                {{$service->created_at->diffForHumans()}}
            </div>
        </div>
    @endif



        {{--    Cover Pic    --}}
        <div class="home-tile row mx-2 mt-3 rounded-5"
             style="
             background-image: url({{asset('storage/service_covers/'.$service->cover) }});
             background-size: cover;
             background-position: center;
             "
        >

        </div>

        <div class="row mt-3 text-center"> <h3>{{$service->title ?? $default}}</h3>  </div>

        {{--    Content    --}}
        <div class="row mx-2 mt-3 px-3 py-2"> {!! $service->description !!} </div>


</div>

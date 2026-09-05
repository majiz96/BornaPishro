<div class="container-fluid avoid-emptiness">

    <div class="row text-center my-4">
        <h2 class="">{{$model->title ?? $model->name}} </h2>
    </div>

    <hr>

    @forelse($this->Filters as $filter)

        <div class="card my-5">
            <div class="card-header h4">
                {{$filter->title}}
            </div>

            <div class="card-body text-center">

                <div class="row">
                    @forelse($filter->options as $option)
                        <div class="col-auto mx-auto border rounded-4"> {{$option->name}} </div>
                    @empty
                        <h5 class="text-danger"> هیچ گزینه ای برای این فیلتر تعریف نکرده اید </h5>
                    @endforelse
                </div>

            </div>

        </div>
    @empty
        <div class="row text-center my-4">
            <h2 class="text-danger"> هیچ فیلتری برای این مورد یا دسته بندی آن تعریف نکرده اید </h2>
        </div>
    @endforelse




</div>

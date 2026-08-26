<!-- Modal -->


@if($filterModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header row">

                    <div class="col-11">
                        <h1 class="modal-title fs-5"> {{ $filterTitle }}  </h1>
                    </div>

                    <div class="col-1 text-start">
                        <button type="button" class="btn-close me-0"  wire:click="$set('filterModal',false)"></button>
                    </div>
                </div>

                <div class="modal-body px-5 text-center">

                    @if($filterUnit->isNotEmpty())

                        <div class="col-xl-3 mx-auto">
                            <div class="row py-2 cs-navbar rounded-4">
                                <div class="col-xl-1 mx-auto"> ردیف </div>
                                <div class="col-xl-2 mx-auto"> دسته </div>
                                <div class="col-xl-2 mx-auto"> محصول </div>
                                <div class="col-xl-3 mx-auto"> عنوان </div>
                                <div class="col-xl-2 mx-auto"> مقدار </div>
                                <div class="col-xl-1 mx-auto"> حذف </div>
                            </div>
                        </div>

                        @foreach($filterUnit as $unit)
                            @foreach($unit->values as $value)

                            <div class="col-xl-3 mt-3 mx-auto">
                                <div class="row border rounded-3 py-2">

                                    <div class="col-xl-1 mx-auto"> {{$counterModal++}} </div>

                                    <div class="col-xl-2 mx-auto"> {{$filterCat}} </div>

                                    <div class="col-xl-2 mx-auto"> {{$unit->specGroup->specification->product->name}} </div>

                                    <div class="col-xl-3 mx-auto"> {{$unit->title}} </div>

                                    <div class="col-xl-3 mx-auto">
                                            {{$value->value}} {{$value->suffix}} &nbsp;
                                    </div>


                                    <div class="col-xl-1 mx-auto">
                                        <button class="btn btn-sm btn-warning rounded-3" wire:click="remove({{$unit->id}})"
                                        wire:confirm="آیا از حذف مشخصه ({{$unit->title}}) از این فیلتر مطمئن هستید؟">

                                            <i class="bi-trash text-dark"></i>

                                        </button>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        @endforeach

                    @else
                        <div class="row"><h3 class="text-danger"> این فیلتر در هیچ مشخصه به کار نرفته است </h3></div>
                    @endif

                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" wire:click="$set('filterModal',false)">
                        بازگشت
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif



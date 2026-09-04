<div class="container">

    <div class="row my-3 main-img text-center">
        <div class="col-xl-3 mx-auto gallery-img">
            <img class="mx-auto social-icon rounded p-2" src="{{asset('storage/products/'.$product->image) }}" alt="پیش نمایش">
        </div>

            <h2 class="my-3">{{$product->name}}</h2>
    </div>

    <div class="row border">

            <button class="btn btn-success rounded-0 mx-auto" wire:click="openCloneList"> استفاده از جدول محصول دیگر </button>

            <form wire:submit.prevent="saveTable" class="row py-2">
                <div class="col-xl-1 my-auto"> <label for="name"> نام جدول </label> </div>
                <div class="col-xl-3 my-auto">
                    <input type="text" id="name" class="form-control" wire:model.live="name">
                    @error('name') <small> {{$message}} </small> @enderror
                </div>


                <div class="col-xl-1 my-auto"> <label for="price"> قیمت </label> </div>
                <div class="col-xl-3 my-auto">
                    <input type="text" id="price" class="form-control" wire:model.live="price">
                    @error('price') <small> {{$message}} </small> @enderror
                </div>

                <div class="col-xl-4 text-xl-start">

                    @if($editingTable)
                        <button type="button" class="btn btn-danger rounded-3 px-4 py-2 w-auto mx-3" wire:click="cancelTable"> انصراف </button>
                    @endif

                    <button type="submit" class="cs-button border-0 rounded-3 px-4 py-2 w-auto mx-3"> ذخیره </button>

                </div>

            </form>

    </div>

    @if($this->Tables->isNotEmpty())

        <div class="row border text-center p-2">
            @foreach($this->Tables as $spec)

                <a class="col-xl-4 text-decoration-none text-body px-3 my-auto">

                    <div class="row border rounded-4 py-1 px-1 {{$activeTable == $spec->id ? 'cs-navbar' : ''}}">
                        <div class="col-8 delete-badge my-auto text-end" wire:click="selectTable({{$spec->id}})">{{$spec->name}}</div>


                        <div class="col-1 pt-1"><i class="bi-trash-fill text-danger" wire:click="deleteTable({{$spec->id}})"
                                                   wire:confirm="آیا از حذف جدول ({{$spec->name}}) مطمئن هستید؟"></i></div>

                        <div class="col-1 pt-1"><i class="bi-pen-fill text-primary" wire:click="editTable( {{$spec->id}} )"></i></div>

                        <div class="col-1 pt-1"><i class="bi-copy bg-body px-2 pt-1 rounded text-warning" wire:click="duplicate( {{$spec->id}} )"></i></div>

                        @if($spec->price)
                            <div class="col-12 bg-dark rounded-bottom-4 rounded-top-2 mt-2 py-1 delete-badge" wire:click="selectTable({{$spec->id}})">
                                {{number_format($spec->price)}} تومان
                            </div>
                        @endif

                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="row border text-center py-2">
            <h2 class="text-danger"> جدولی برای این محصول ثبت نشده است </h2>
        </div>
    @endif






        {{--  Specification Groups  --}}
        <form wire:submit.prevent="saveGroup" class="row border py-2">

            <div class="col-xl-1 my-auto"> <label for="group"> نام گروه </label> </div>

            <div class="col-xl-4 my-auto">
                <input type="text" id="group" class="form-control" wire:model.blur="group">
                @error('group') <small> {{$message}} </small> @enderror
            </div>

            <div class="col-xl-4"></div>


            <div class="col-xl-3 my-auto text-start">

                @if($this->editingGroup)
                    <button type="button" class="btn btn-danger mx-3" wire:click="cancelGroup">انصراف</button>
                @endif

                <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
            </div>
        </form>


        {{--  Specification Unit --}}
        <form wire:submit.prevent="saveUnit" class="row py-2 border">

            <div class="col-xl-1 my-auto"> <label for="title"> عنوان سطر </label> </div>
            <div class="col-xl-4 my-auto">
                <input type="text" id="title" class="form-control" wire:model.live="title">
                @error('title') <small> {{$message}} </small> @enderror
            </div>

            <div class="col-xl-4"></div>

            <div class="col-xl-3 my-auto text-start">

                @if($this->editingUnit)
                    <button type="button" class="btn btn-danger mx-3" wire:click="cancelUnit">انصراف</button>
                @endif

                <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
            </div>

        </form>


        {{--  Specification Value --}}
        <form wire:submit.prevent="saveValue" class="row py-2 border">

            <div class="col-xl-1 my-auto"> <label for="value"> مقدار </label> </div>
            <div class="col-xl-4 my-auto">
                <input type="text" id="value" class="form-control" wire:model.live="value">
                @error('value') <small> {{$message}} </small> @enderror
            </div>

            <div class="col-xl-4"></div>

            <div class="col-xl-3 my-auto text-start">

                @if($this->editingValue)
                    <button type="button" class="btn btn-danger mx-3" wire:click="cancelValue">انصراف</button>
                @endif

                <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
            </div>

        </form>


        {{--    Showing the results     --}}




        @if($this->Groups->isNotEmpty())

            @foreach($this->Groups as $group)

                <div class="card row mt-5">

                    <div class="card-header {{$activeGroup == $group->id ? 'bg-secondary text-light' : ''}}">
                        <div class="row">

                            <div class="col-9 delete-badge" wire:click="selectGroup({{$group->id}})">
                                {{$group->title}}
                            </div>

                            <div class="col-1">
                                <button class="btn btn-sm btn-warning rounded-3"
                                        wire:click="empty({{$group->id}})" wire:confirm="آیا از تخلیه گروه ({{$group->title}}) مطمئن هستید؟">
                                    تخلیه
                                </button>
                            </div>

                            <div class="col-1">
                                <button class="btn btn-sm btn-danger rounded-3"
                                        wire:click="deleteGroup({{$group->id}})" wire:confirm="آیا از حذف گروه ({{$group->title}}) مطمئن هستید؟">
                                    حذف
                                </button>
                            </div>

                            <div class="col-1">
                                <button class="btn btn-sm btn-primary rounded-3" wire:click="editGroup({{$group->id}})">ویرایش</button>
                            </div>
                        </div>


                    </div>

                    <div class="card-body">

                        @if($group->units->isNotEmpty())

                            @foreach($group->units as $unit)
                                <div class="row border rounded my-3 {{$activeUnit == $unit->id ? 'bg-info-subtle' : ''}}">

                                    <div class="col-xl-1 text-end px-1 py-1 my-auto rounded-end delete-badge" wire:click="selectUnit({{$unit->id}})">

                                        @if($activeUnit == $unit->id)
                                            <button class="btn btn-success fs-4 py-0 w-100"><i class="bi-check"></i></button>
                                        @else
                                            <button class="btn btn-secondary">انتخاب</button>
                                        @endif

                                    </div>


                                    <div class="col-xl-1 text-center py-1 my-auto">
                                        <button class="btn btn-sm btn-danger rounded-3"
                                                wire:click="deleteUnit({{$unit->id}})" wire:confirm="آیا از حذف گروه ({{$unit->title}}) مطمئن هستید؟">
                                            حذف
                                        </button>
                                    </div>

                                    <div class="col-xl-1 text-center py-1 my-auto">
                                        <button class="btn btn-sm btn-primary rounded-3" wire:click="editUnit({{$unit->id}})">ویرایش</button>
                                    </div>


                                    <div class="col-xl-2 py-1 my-auto text-start">{{$unit->title}} :</div>


                                    <div class="col-xl-7 py-1 my-auto">

                                        @if($unit->values->isNotEmpty())

                                            @foreach($unit->values as $value)

                                                <div class="row text-end pe-3 border rounded-5 py-1 my-2 mx-auto">

                                                        <div class="col-10">{{$value->value}}</div>

                                                    <div class="col-1 text-start"><i class="bi-trash-fill text-danger" wire:click="deleteValue({{$value->id}})"
                                                                                     wire:confirm="آیا از حذف مقدار ({{$value->value}}) مطمئن هستید؟"></i></div>

                                                    <div class="col-1 text-start"><i class="bi-pen-fill text-primary" wire:click="editValue( {{$value->id}} )"></i></div>

                                                </div>

                                            @endforeach

                                        @else

                                            <div class="row text-end">
                                                <h5 class="text-danger"> هیچ مقداری ثبت نکرده اید </h5>
                                            </div>

                                        @endif


                                    </div>


                                </div>
                            @endforeach

                        @else
                            <div class="row text-center"> <h3> هیچ مشخصاتی برای این گروه ثبت نکرده اید </h3> </div>
                        @endif



                    </div>

                </div>
            @endforeach

        @else

            <div class="row text-center mt-5"><h2> هیچ گروهی برای جدول انتخاب شده ساخته نشده است </h2></div>

        @endif

    @if($cloneList)
        @include('modals.clone-list')
    @endif



</div>

<div class="container">

    <div class="row border">

        <div class="col-xl-2 text-center side-img2 border">
        <img class="mx-auto social-icon rounded p-2" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">
        <h2>{{$products->name}}</h2>

        </div>

        <div class="col-xl-10 my-auto">

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

    </div>

    @if($specifications->isNotEmpty())

            <div class="row border text-center p-2">
        @foreach($specifications as $spec)

                <a class="col-xl-3 text-decoration-none text-body px-4 my-auto">
                    <div class="row border rounded-4 py-1 px-1 {{$activeTable == $spec->id ? 'cs-navbar' : ''}}">
                        <div class="col-8 delete-badge my-auto text-end" wire:click="selectTable({{$spec->id}})">{{$spec->name}}</div>


                        <div class="col-1 pt-1"><i class="bi-trash-fill text-danger" wire:click="deleteTable({{$spec->id}})"
                        wire:confirm="آیا از حذف جدول ({{$spec->name}}) مطمئن هستید؟"></i></div>

                        <div class="col-1"></div>
                        <div class="col-1 pt-1"><i class="bi-pen-fill text-primary" wire:click="editTable( {{$spec->id}} )"></i></div>


                        @if($spec->price)
                            <div class="col-12 bg-dark rounded-bottom-4 rounded-top-2 py-1 delete-badge" wire:click="selectTable({{$spec->id}})"> {{number_format($spec->price)}} تومان </div>

                        @endif

                    </div>
                </a>
        @endforeach
            </div>






        {{--  Specification Groups  --}}
        <form wire:submit.prevent="saveGroup" class="row border py-2">

            <div class="col-xl-1 my-auto"> <label for="group"> عنوان گروه </label> </div>

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

            <div class="col-xl-2 my-auto">

                <select wire:model.live="filter_id" class="form-select">
                    @if($filters->isNotEmpty())
                        <option value="">انتخاب برای فیلتر</option>
                        @foreach($filters as $filter)
                         <option value="{{$filter->id}}">{{$filter->title}}</option>
                        @endforeach
                    @else
                    <option value="">فیلتری ثبت نشده است</option>
                    @endif

                </select>

            </div>

            <div class="col-xl-1 my-auto text-start"> <label for="title"> عنوان </label> </div>
            <div class="col-xl-2 my-auto">
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

            <div class="col-xl-1 my-auto text-center">
                <input type="radio" class="btn-check mx-3" id="btn-check-string-outlined" autocomplete="off" wire:model.live="type" value="string">
                <label class="btn btn-outline-success w-auto rounded-5 py-2" for="btn-check-string-outlined">متنی</label>
            </div>

            <div class="col-xl-1 my-auto text-center">
                <input type="radio" class="btn-check mx-3" id="btn-check-integer-outlined" autocomplete="off" wire:model.live="type" value="integer">
                <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-integer-outlined">عددی</label>
            </div>

            <div class="col-xl-1 my-auto text-start"> <label for="value"> مقدار </label> </div>
            <div class="col-xl-2 my-auto">
                <input type="text" id="value" class="form-control" wire:model.live="value">
                @error('value') <small> {{$message}} </small> @enderror
            </div>


            @if($type == 'integer')
                <div class="col-xl-1 my-auto text-start"> <label for="suffix"> پسوند </label> </div>
                <div class="col-xl-1 my-auto">
                    <input type="text" id="suffix" class="form-control" wire:model.live="suffix">
                    @error('suffix') <small> {{$message}} </small> @enderror
                </div>
                <div class="col-xl-2"></div>
            @else

                <div class="col-xl-4"></div>
            @endif



            <div class="col-xl-3 my-auto text-start">

                @if($this->editingValue)
                    <button type="button" class="btn btn-danger mx-3" wire:click="cancelValue">انصراف</button>
                @endif

                <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
            </div>

        </form>


            {{--    Showing the results     --}}




    @if($groups->isNotEmpty())

        @foreach($groups as $group)

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

                                                    @if($value->type == 'integer')
                                                        <div class="col-4">
                                                            <span class="mx-1">{{$value->value}}</span>
                                                            <span>{{$value->suffix}}</span>
                                                        </div>

                                                        <div class="col-6"></div>
                                                    @else
                                                        <div class="col-10">{{$value->value}}</div>
                                                    @endif



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

    <div class="row text-center mt-5"><h2> هیچ گروه و مشخصاتی برای جدول ({{$table}}) ثبت نشده است </h2></div>

    @endif

    @else
        <div class="row border text-center py-2">
            <h2 class="text-danger"> جدولی برای این محصول ثبت نشده است </h2>
        </div>
    @endif

</div>

<div class="container">

    <div class="row text-center">
        <h2>{{$filter->title}}</h2>
    </div>

    <form class="row border rounded-3 py-2 my-5 d-flex" wire:submit.prevent="save">

        <div class="col-auto text-start my-auto"><label for="name"> نام : </label></div>

        <div class="col-xl-4">
            <input type="text" class="form-control" name="name" wire:model.blur="name">
        </div>

        <div class="col-xl-auto my-auto">
            @error('name') <small class="text-danger my-auto"> {{$message}} </small> @enderror
        </div>


        <div class="col-auto flex-fill"></div>

        <div class="col-xl-1 text-start">
            <div class="row text-start">

               @if($editing)
                    <button class="btn btn-danger w-auto mx-auto left" type="button" wire:click="cancel"> انصراف </button>
               @endif

                <button class="btn rounded-3 w-auto cs-button mx-auto left" type="submit"> ذخیره </button>

            </div>
        </div>

    </form>


    <div class="row my-4 text-center">

        @if($this->Options->isNotEmpty())

            <div class="row my-3">

                <div class="col-1 text-end px-3 my-auto">
                        <input type="checkbox">
                </div>

                <lable class="col-1 text-start my-auto">
                    نمایش همه
                </lable>

                <div class="col-1 text-end px-2 my-auto">
                    <input type="checkbox">
                </div>

                <dvi class="col-7 pe-4 text-end">نام گزینه</dvi>


                <dvi class="col-1 text-end"> حذف </dvi>
                <dvi class="col-1 text-end"> ویرایش </dvi>

            </div>

            <div class="accordion my-4" id="FilterAccordion">


                @foreach($this->Options as $option)

                    <div class="accordion-item row px-0 d-flex">

                        <div class="col-1 text-end px-3 my-auto">
                            <input type="checkbox">
                        </div>

                        <lable class="col-1 text-start my-auto">
                            نمایش
                        </lable>

                        <div class="col-1 text-end px-2 my-auto">
                            <input type="checkbox">
                        </div>

                        <h2 class="accordion-header col-9 px-0" id="heading{{$option->id}}">

                            <button class="accordion-button collapsed d-flex" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$option->id}}" aria-expanded="false" aria-controls="collapse{{$option->id}}">

                                <div class="col-9 text-end">
                                    {{$option->name}}
                                </div>

                                <div class="col-1 btn btn-sm btn-danger w-auto offset-1" wire:click="delete({{$option->id}})" wire:confirm="آیا از حذف آپشن ({{$option->name}}) مطمئن هستید؟">
                                    حذف
                                </div>

                                <div class="col-1 btn btn-sm btn-primary w-auto" wire:click="edit({{$option->id}})">
                                    ویرایش
                                </div>


                                <div class="col-auto flex-fill"></div>

                            </button>

                        </h2>

                        <div id="collapse{{$option->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$option->id}}" data-bs-parent="#FilterAccordion">
                            <div class="accordion-body">
                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>

                    </div>

                @endforeach






            </div>


        @else
            <h2 class="text-danger my-5">  فیلتر ( {{$filter->title}} ) هیچ گزینه ای ندارد </h2>
        @endif




    </div>

</div>

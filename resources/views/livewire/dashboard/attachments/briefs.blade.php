<div class="container">

   <div class="row mt-3">

       <div class="col-xl-2 side-img2 text-center mx-auto overflow-hidden">

           <img class="rounded-4" src="{{asset('storage/products/'.$product->image) }}" width="64" alt="پیش نمایش">

           <h2> {{$product->name}} </h2>

       </div>
       <div class="col-xl-10">
           <form wire:submit.prevent="save" class="row h-100">

            <div class="col-xl-1 my-auto text-center"><label for="title">عنوان</label></div>
            <div class="col-xl-4 my-auto">
                <input type="text" id="title" class="form-control" wire:model.blur="title">
                @error('title') <smal class="text-danger"> {{$message}} </smal> @enderror
            </div>

            <div class="col-xl-1 my-auto text-center"><label for="value">مقدار</label></div>
            <div class="col-xl-4 my-auto">
                <input type="text" id="value" class="form-control" wire:model.blur="value">
                @error('value') <smal class="text-danger"> {{$message}} </smal> @enderror
            </div>

            <div class="col-xl-2 my-auto text-center">

                @if($editing)

                    <button type="button" class="btn btn-sm btn-danger border-0 w-auto rounded-3 mx-2" wire:click="cancel"> انصراف </button>

                @endif

                    <button type="submit" class="btn btn-sm btn-primary border-0 w-auto rounded-3 mx-2"> ذخیره </button>

            </div>

           </form>

       </div>


       @if($units->isNotEmpty())

           <div class="cs-navbar row text-center py-2 border rounded-3 mt-5 mb-2">

               <div class="col-xl-1 mx-auto"><input type="checkbox" wire:model.live="selectAll"></div>
               <div class="col-xl-1 mx-auto">ردیف</div>
               <div class="col-xl-2 mx-auto">عنوان</div>
               <div class="col-xl-2 mx-auto">مقدار</div>

               <div class="col-xl-1 mx-auto">

                   @if(count($selected)>1)
                       <button class="btn btn-sm btn-danger w-auto rounded-3"
                       wire:click="deleteSelected" wire:confirm=" آیا از حذف عناوین و مقداریرشان مطمئن هستید ">
                           حذف انتخابی
                       </button>
                   @else
                       حذف
                   @endif

               </div>

               <div class="col-xl-1 mx-auto">ویرایش</div>

           </div>

           @foreach($units as $unit)

               <div class="row text-center py-3 border-bottom">

                   <div class="col-xl-1 mx-auto"><input type="checkbox" wire:model.live="selected" value="{{$unit->id}}"></div>
                   <div class="col-xl-1 mx-auto">{{$counter++}}</div>
                   <div class="col-xl-2 mx-auto">{{$unit->title}}</div>
                   <div class="col-xl-2 mx-auto">{{$unit->values->value}}</div>

                   <div class="col-xl-1 mx-auto">
                   <button class="btn btn-sm btn-danger w-auto rounded-3"
                   wire:click="delete({{$unit->id}})" wire:confirm=" آیا از حذف عنوان و مقدارش ({{$unit->title}}) مطمئن هستید "> حذف
                   </button>
                   </div>

                   <div class="col-xl-1 mx-auto"><button class="btn btn-sm btn-primary w-auto rounded-3" wire:click="edit({{$unit->id}})"> ویرایش </button></div>

               </div>

           @endforeach

       @else
           <div class="row text-center mt-5"><h2 class="text-danger"> هیچ خلاصه مشخصاتی ثبت نشده است </h2></div>
       @endif

       <div class="row mt-3">
           <div class="col-xl-1"></div>
           <div class="col-xl-1"></div>
       </div>

   </div>

</div>

<div class="container">


    <div class="row text-center mx-auto">
        <div class="col-xl-5 my-auto"></div>
        <img class="col-xl-2 mx-auto" src="{{asset('storage/products/'.$product->image) }}"  alt="پیش نمایش">
        <div class="col-xl-5"></div>
    </div>

    <div class="row text-center my-2"><h1>{{$products->name}}</h1></div>


    <form class="row text-center mx-auto mt-3 py-3 border rounded-4" wire:submit.prevent="save">


        <div class="col-xl-1 my-auto text-xl-center"><label for="title"> عنوان ویدیو </label> </div>
        <div class="col-xl-11 my-auto">
            <input type="text" class="form-control" id="title" wire:model.blur="title">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>


        <div class="col-xl-1 mt-5 text-xl-start"><label for="aparat"> آپارات </label> </div>
        <div class="col-xl-4 mt-5">
            <input type="text" class="form-control" id="aparat" wire:model.blur="aparat">
            @error('aparat') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-1 mt-5 text-xl-start"><label for="youtube"> یوتوب </label> </div>
        <div class="col-xl-4 mt-5">
            <input type="text" class="form-control" id="youtube" wire:model.blur="youtube">
            @error('youtube') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-xl-2 mt-5">
                <select wire:model.blur="priority" class="form-select">

            @if($aparat && $youtube)
                    <option value=""> اولویت پخش </option>
                    <option value="آپارات"> آپارات </option>
                    <option value="یوتوب"> یوتوب </option>

            @elseif($youtube == "")
                {{$priority == 'آپارات'}}
                    <option value="آپارات"> آپارات </option>

            @else
                        {{$priority == 'یوتوب'}}
                    <option value="یوتوب"> یوتوب </option>
            @endif
                </select>

            @error('priority') <small class="text-danger">{{ $message }}</small> @enderror
        </div>


        <div class="col-xl-12 my-3 text-end">
            <label for="text" class="form-label">توضیحات</label>
            <textarea class="form-control" id="text" rows="2" wire:model.blur="description"></textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        @if($editing)
            <button type="button" class="btn btn-danger border-0 py-2 px-4 rounded-3 w-auto my-2 mx-auto" wire:click="cancel"> انصراف </button>
        @endif

        <button type="submit" class="cs-button border-0 py-2 px-4 rounded-3 w-auto my-2 mx-auto"> ذخیره </button>

    </form>


    {{--  Show files of this product  --}}

    @if($product_videos->isNotEmpty())

        <div class="row mt-3 border-bottom py-3 text-center">
            <div class="col-xl-1"><input type="checkbox" wire:model.live="selectAll"></div>


            <div class="col-xl-1">
                @if(count($showed_videos) == count($product_videos))
                    <label for="show"> نمایش همه </label>
                    <input type="checkbox" id="show" wire:change="showNone" checked>

                @else
                    <label for="show"> {{count($showed_videos)}} ویدیو </label>
                    <input type="checkbox" id="show" wire:change="showAll">
                @endif
            </div>

            <div class="col-xl-1">ردیف</div>

            <div class="col-xl-4 text-center">عنوان</div>

            <div class="col-xl-2 text-center">پلتفرم</div>

            <div class="col-xl-1 text-center">مشاهده</div>

            <div class="col-xl-1">
                @if(count($selected)>1)
                    <button class="btn btn-sm btn-danger rounded-3" wire:click="deleteSelected" wire:confirm="آیا از حذف ویدیوهای انتخاب شده مطمئن هستید؟">
                        حذف انتخابی
                    </button>
                @else
                    حذف
                @endif
            </div>

            <div class="col-xl-1 text-end"> ویرایش </div>
        </div>

        @foreach($product_videos as $video)

            <div class="row mt-3 border rounded-4 py-3 text-center">

                <div class="col-xl-1 my-auto"><input type="checkbox" wire:model.live="selected" value="{{$video->id}}"></div>

                <div class="col-xl-1 my-auto"><input type="checkbox" wire:change="toggleShow({{$video->id}})" @checked($video->show == 1)></div>

                <div class="col-xl-1 my-auto">{{$counter++}}</div>

                <div class="col-xl-4 my-auto">{{$video->title}}</div>

                <div class="col-xl-2 my-auto">

                    @if($video->youtube == "")
                        آپارات
                    @elseif($video->aparat == "")
                        یوتوب
                    @else
                        آپارات و یوتوب
                    @endif

                </div>

                <div class="col-xl-1 my-auto"><button class="btn btn-sm btn-success rounded-3" wire:click="see({{$video->id}})">مشاهده</button></div>

                <div class="col-xl-1 my-auto">
                    <button class="btn btn-sm btn-danger rounded-3"
                            wire:click="delete({{$video->id}})" wire:confirm="آیا از حذف فایل ({{$video->file}}) مطمئن هستید؟">
                        حذف
                    </button>
                </div>

                <div class="col-xl-1 my-auto text-end"><button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$video->id}})">ویرایش</button></div>



            </div>
            @include('modals.see-video')
        @endforeach


    @else
        <div class="row mt-3 border rounded-4 py-3 text-center"><h3 class="text-danger my-auto"> فایلی برای این محصول ثبت نشده است </h3></div>
    @endif


</div>

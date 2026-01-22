<div class="container-fluid">

    <div class="row text-center"><h2 wire:text="message"></h2></div>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="row border rounded-4 pt-4 px-2" >

        @csrf

        <div class="col-xl-1 my-auto mx-auto text-start"><label for="title">عنوان</label></div>

        <div class="col-xl-5 my-auto mx-auto">
            <input type="text" id="title" class="form-control" wire:model.blur="title">
            @error('title') <small class="text-danger"> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-4"></div>

        <div class="col-xl-2 my-auto">
            <select class="form-select" wire:model="category_id">
                <option value=""> دسته را انتخاب کنید </option>

                @if($categories->isNotEmpty())

                    @foreach($categories as $category)

                        @if($category->children->isNotEmpty())

                            <optgroup label="{{$category->name}}">

                                @foreach($category->children as $child)

                                    <option value="{{$child->id}}">{{$child->name}}</option>

                                @endforeach

                            </optgroup>

                        @else

                            <option value="{{$category->id}}">{{$category->name}}</option>

                        @endif

                    @endforeach

                @else
                    <option value=""> دسته ای برای مقالات ثبت نکرده اید! </option>
                @endif

            </select>
            @error('category_id') <small class="text-danger"> {{$message}} </small> @enderror
        </div>



        <div class="col-xl-1 my-auto text-xl-start mx-auto mt-3"><label for="cover">انتخاب نمایه</label></div>
        <div class="col-xl-2 my-auto mx-auto">
            <input type="file" id="cover" class="form-control" wire:model.blur="cover">
            @error('cover') <small class="text-danger"> {{$message}} </small> @enderror
        </div>


        <div class="col-xl-3 my-auto text-xl-end mx-auto side-img2">
            @if($cover)
                @if(is_string($cover) && $editing)
                    <img src="{{asset('storage/service_covers/'.$cover) }}"  alt="پیش نمایش" class="mt-3">
                @else
                    <img src="{{$cover->temporaryUrl()}}" alt="پیش نمایش" class="mt-3 rounded">
                @endif
            @endif



        </div>


        <div class="col-xl-1 my-auto text-xl-start mx-auto mt-3"><label for="thumbnail">انتخاب نمایه کوچک</label></div>
        <div class="col-xl-2 my-auto mx-auto mt-3">
            <input type="file" id="thumbnail" class="form-control" wire:model.blur="thumbnail">
            @error('thumbnail') <small class="text-danger"> {{$message}} </small> @enderror
        </div>


        <div class="col-xl-2 my-auto text-xl-end mx-auto side-img2 mt-3">
            @if($thumbnail)
                @if(is_string($thumbnail) && $editing)
                    <img src="{{asset('storage/service_thumbnails/'.$thumbnail) }}"  alt="پیش نمایش" class="mt-3">
                @else
                    <img src="{{$thumbnail->temporaryUrl()}}" alt="پیش نمایش" class="mt-3 rounded">
                @endif
            @endif

        </div>

        <div class="row mx-auto mt-3">
            <label for="intro">مقدمه</label>
            <textarea id="intro" class="form-control" rows="1" wire:model.blur="intro"></textarea>
            @error('intro') <small class="text-danger"> {{$message}} </small> @enderror

        </div>

        <div class="row mx-auto mt-3">
            <label for="description">متن</label>
            <textarea id="description" class="form-control" rows="3" wire:model.blur="description"></textarea>
            @error('description') <small class="text-danger"> {{$message}} </small> @enderror
        </div>

        <div class="row mx-auto py-4">

            @if($editing)
                <button type="button" class="btn btn-danger w-auto mx-auto rounded-4" wire:click="cancel" > انصراف </button>
            @endif

            <button type="submit" class="cs-button border-0 rounded-4 py-2 px-4 w-auto mx-auto"> ذخیره </button>

        </div>


    </form>


    {{--  showing categories  --}}

    <div class="row mt-3">

        <div class="col-xl-1 border rounded-4 pb-2">
            @if($categories->isNotEmpty())
                @foreach($categories as $category)

                    <div class="row border mt-2 mx-1 rounded-4 py-2 text-center delete-badge {{ $activeParent == $category->id ? 'cs-button text-light' : '' }}"
                         wire:click="selectParent({{$category->id}})">
                        <h5 class="my-auto">{{$category->name}}</h5>
                    </div>

                @endforeach
            @else
                <div class="row text-center"> <h2 class="text-danger"> دسته ای ثبت نکرده اید </h2> </div>
            @endif
        </div>

        <div class="col-xl-11 my-auto py-5 border rounded-start-4">
            <div class="row">

                @if($children->isNotEmpty() && $activeParent)
                    @foreach($children as $child)
                        <div class="col-xl mt-3 mx-auto text-center delete-badge"
                             wire:click="$set('activeChild',{{$child->id}})">
                            <h5 class=" border rounded-4 py-2 {{ $activeChild == $child->id ? 'cs-button text-light' : '' }}">{{$child->name}}</h5>
                        </div>
                    @endforeach
                @else
                    <div class="row text-center"> <h2 class="text-danger mt-5"> دسته ای ثبت نکرده اید </h2> </div>
                @endif
            </div>
        </div>

    </div>

    {{--  showing services  --}}
    <div class="row mt-4 py-2 px-0 border rounded-4">

        @if($services->isNotEmpty())

            @foreach($services as $service)

                <div class="col-xl-4 card rounded-4 my-2 mx-auto">

                    <div class="card-header row">
                        <div class="col-xl-8"><h5>{{$service->title}}</h5></div>
                        <div class="col-xl-4 text-xl-start">{{$service->created_at}}</div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <img src="{{asset('storage/service_covers/'.$service->cover) }}"  alt="پیش نمایش" class="mt-3 mx-auto">
                        </div>

                        <div class="row my-2">{{$service->intro}}</div>

                    </div>

                    <div class="card-footer row">

                        <div class="col-xl-1 text-xl-start my-auto"><label for="show"> نمایش </label></div>
                        <div class="col-xl-1 my-auto"><input type="checkbox" id="show" wire:change="toggleShow({{$service->id}})" @checked($service->show == 1)></div>

                        <div class="col-xl-2 my-auto text-center">
                            <button class="btn btn-sm btn-success rounded-3" wire:click="see({{$service->id}})"> مشاهده </button>
                        </div>

                        <div class="col-xl-2 my-auto text-center">
                            <button class="btn btn-sm btn-danger rounded-3" wire:click="delete({{$service->id}})"
                                    wire:confirm="آیا از حذف مقاله ({{$service->title}}) مطمئن هستید؟"> حذف </button>
                        </div>

                        <div class="col-xl-2 my-auto text-center">
                            <button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$service->id}})"> ویرایش </button>
                        </div>


                    </div>

                </div>

                @if($modal)
                    @include('modals.see-service')
                @endif


            @endforeach
        @else
            <div class="row text-center my-auto"><h3 class="text-danger"> در این دسته مقاله ای ثبت نکرده اید </h3></div>
        @endif



    </div>


</div>

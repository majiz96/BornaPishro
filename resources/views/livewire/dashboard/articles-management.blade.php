<div class="container-fluid">

    <div class="row text-center"><h2 wire:text="message"></h2></div>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="row border rounded-4 pt-4 px-2" >

        @csrf

        <div class="col-xl-1 my-auto text-xl-start mx-auto"><label for="title">عنوان</label></div>
        <div class="col-xl-3 my-auto mx-auto">
            <input type="text" id="title" class="form-control" wire:model.blur="title">
            @error('title') <small class="text-danger"> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-2 my-auto">
            <select class="form-select" wire:model="category_id">
                <option value=""> دسته را انتخاب کنید </option>

                @if($this->Categories->isNotEmpty())

                    @foreach($this->Categories as $category)

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



        <div class="col-xl-1 my-auto text-xl-start mx-auto"><label for="cover">انتخاب نمایه</label></div>
        <div class="col-xl-2 my-auto mx-auto">
            <input type="file" id="cover" class="form-control" wire:model.blur="cover">
            @error('cover') <small class="text-danger"> {{$message}} </small> @enderror
        </div>


        <div class="col-xl-3 my-auto text-xl-end mx-auto side-img2">
            @if($cover)
                @if(is_string($cover) && $editing)
                    <img src="{{asset('storage/article_covers/'.$cover) }}"  alt="پیش نمایش" class="mt-3">
                @else
                    <img src="{{$cover->temporaryUrl()}}" alt="پیش نمایش" class="mt-3 rounded">
                @endif
            @endif

        </div>

        <div class="row mx-auto mt-3">
            <label for="intro">مقدمه</label>
            <textarea id="intro" class="form-control" rows="1" wire:model.blur="intro"></textarea>
            @error('intro') <small class="text-danger"> {{$message}} </small> @enderror

        </div>

        <div class="mx-auto mt-3" wire:ignore>
            <textarea id="summernote"></textarea>
        </div>
        @error('content')<div class="text-danger mt-2">{{ $message }}</div>@enderror

        <div class="row mx-auto py-4">

            @if($editing)
                <button type="button" class="btn btn-danger w-auto mx-auto rounded-4" wire:click="cancel" > انصراف </button>
            @endif

                <button type="submit" class="cs-button border-0 rounded-4 py-2 px-4 w-auto mx-auto"> ذخیره </button>

        </div>


    </form>


        {{--  showing categories  --}}

    <div class="row mt-3">

        <div class="col-xl-2 border rounded-end-4">
            @if($this->Categories->isNotEmpty())
                @foreach($this->Categories as $category)

                    <div class="row border mt-2 mx-1 rounded-4 py-2 text-center delete-badge {{ $activeParent == $category->id ? 'cs-button text-light' : '' }}"
                    wire:click="selectParent({{$category->id}})">

                        <h5 class="my-auto">
                            {{$category->name}}

                            @if($this->commentCategoryAlert($category->id))
                                <span class="mx-auto text-bg-danger px-1 py-0 rounded-5 me-2">
                                {{$this->commentCategoryAlert($category->id)}}
                                </span>
                            @endif


                        </h5>

                    </div>

                @endforeach
            @else
            <div class="row text-center"> <h2 class="text-danger"> دسته ای ثبت نکرده اید </h2> </div>
            @endif
        </div>

        <div class="col-xl-10 my-auto py-5 border rounded-start-4">
            <div class="row">

            @if($this->Children->isNotEmpty() && $activeParent)
                @foreach($this->Children as $child)
                    <div class="col-auto mt-3 mx-auto text-center delete-badge"
                         wire:click="selectChildren({{$child->id}})">

                        <h5 class=" border row rounded-4 p-3 {{ $activeChild == $child->id ? 'cs-button text-light' : '' }}">

                            <div class="col-auto">
                            {{$child->name}}
                            </div>


                            @if($this->commentChildAlert($child->id))
                                <div class="col-auto mx-auto text-bg-danger px-1 py-0 rounded-5 me-2">
                                    {{ $this->commentChildAlert($child->id) }}
                                </div>
                            @endif

                        </h5>

                    </div>
                @endforeach

            @else
                <div class="row text-center"> <h2 class="text-danger mt-5"> دسته ای ثبت نکرده اید </h2> </div>
            @endif
            </div>
        </div>

    </div>

        {{--  showing articles  --}}
    <div class="row my-4 py-2 px-0 border rounded-4">

        @if($this->Articles->isNotEmpty())

            <div class="row mt-4">

                <div class="col-xl-3">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="جستجو" autocomplete="off">
                </div>

                <div class="col-xl-1">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="3">3</option>
                        <option value="6">6</option>
                        <option value="9">9</option>
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="32">32</option>
                        <option value="">همه</option>
                    </select>
                </div>

                <div class="col-xl-1">
                    <select wire:model.live="sort" class="form-select">
                        <option value="created_at">تاریخ ایجاد</option>
                        <option value="title">عنوان</option>
                    </select>
                </div>

                <div class="col-xl-1 my-auto">
                    <select class="form-select" wire:model.live="direction">
                        <option value="desc">نزولی</option>
                        <option value="asc">صعودی</option>
                    </select>
                </div>

            </div>

            @foreach($this->Articles as $article)

                <div class="col-xl-4 my-3">

                    <div class="card rounded-4 my-2 mx-auto">

                        <div class="card-header">
                            <div class="row d-flex">
                                <div class="col-xl-auto flex-fill"><h5>{{$article->title}}</h5></div>
                                <div class="col-xl-auto text-xl-start">
                                    {{$article->toJalaiDateByHours($article->created_at)}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body delete-badge"  wire:click="see({{$article->id}})">

                            <div class="row">
                                <img src="{{asset('storage/article_covers/'.$article->cover) }}"  alt="پیش نمایش" class="mt-3 mx-auto cs-cover-image">
                            </div>

                            <div class="row my-2">{{$article->intro}}</div>

                        </div>

                        <div class="card-footer">

                            <div class="row d-flex">
                                <div class="col-xl-auto">

                                    {{$article->writer->name}}

                                    {{$article->writer->lastname}}

                                </div>

                                <div class="col-xl-auto text-xl-start my-auto"><label for="show"> نمایش </label></div>
                                <div class="col-xl-auto my-auto"><input type="checkbox" id="show" wire:change="toggleShow({{$article->id}})" @checked($article->show == 1)></div>

                                <div class="col-auto flex-fill"></div>

                                <div class="col-xl-auto my-auto text-center">
                                    @if($this->commentAlert($article->id))
                                        <a href="{{ route('comments', [
                                        'type' => Article::Class,
                                        'id'   => $article->id,
                                    ]) }}" class="dropdown-item" wire:navigate>

                                            <button class="btn btn-sm btn-secondary rounded-3" wire:click="edit({{$article->id}})">
                                                کامنتها
                                                <span class="mx-auto text-bg-danger px-1 py-0 rounded-5 me-2">
                                                    {{ $this->commentAlert($article->id) }}
                                                </span>
                                            </button>

                                        </a>
                                    @elseif($this->commentCount($article->id))
                                        <a href="{{ route('comments', [
                                        'type' => Article::Class,
                                        'id'   => $article->id,
                                    ]) }}" class="dropdown-item" wire:navigate>

                                            <button class="btn btn-sm btn-secondary rounded-3" wire:click="edit({{$article->id}})">
                                                کامنتها
                                                <span class="mx-auto text-bg-secondary px-1 py-0 rounded-5 me-2">
                                                    {{ $this->commentCount($article->id) }}
                                                </span>
                                            </button>

                                        </a>
                                    @endif


                                </div>

                                <div class="col-xl-auto my-auto text-center">
                                    <a href="{{ route('select-filter', [
                                        'type' => "article",
                                        'id'   => $article->id,
                                    ]) }}" class="btn btn-sm btn-success rounded-3 text-decoration-none" wire:navigate>
                                        فیلتر ها
                                    </a>
                                </div>

                                <div class="col-xl-1 my-auto text-center">
                                    <button class="btn btn-sm btn-danger rounded-3" wire:click="delete({{$article->id}})"
                                            wire:confirm="آیا از حذف مقاله ({{$article->title}}) مطمئن هستید؟"> حذف </button>
                                </div>

                                <div class="col-xl-2 my-auto text-center">
                                    <button class="btn btn-sm btn-primary rounded-3" wire:click="edit({{$article->id}})"> ویرایش </button>
                                </div>

                            </div>

                        </div>

                    </div>


                </div>

                @if($modal)
                     @include('modals.see-article')
                @endif


            @endforeach
        @else
            <div class="row text-center my-auto"><h3 class="text-danger"> در این دسته مقاله ای ثبت نکرده اید </h3></div>
        @endif


    </div>

    @if($perPage !== "")
        {{$this->Articles->links(data:['scrollTo',false])}}
    @endif

</div>

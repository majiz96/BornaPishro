<div class="container-fluid py-0">



    @if($this->notificationSlider->isNotEmpty() && count($this->notificationSlider) > 1)

        {{-- resources/views/livewire/slider-component.blade.php --}}
        <div id="mySlider" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                @foreach($this->notificationSlider as $index => $notice)
                    <button type="button" data-bs-target="#mySlider" data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"
                            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <!-- The slideshow -->
            <div class="carousel-inner">
                @foreach($this->notificationSlider as $index => $notice)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="home-tile row bg-{{ $notice->style }} text-light text-center mx-2 rounded-5">
                            <h2 class="mx-auto my-auto">{{ $notice->title }}</h2>
                            <p>{{ $notice->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mySlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mySlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    @if(count($this->notificationSlider) == 1)
        @foreach($this->notificationSlider as $notice)
                <div class="home-tile row bg-{{ $notice->style }} text-light text-center mx-2 rounded-5">
                    <h2 class="mx-auto my-auto">{{ $notice->title }}</h2>
                    <p>{{ $notice->description }}</p>
                </div>
        @endforeach
    @endif

    <div class="row text-center mx-2">

        <div class="col-xl-2 home-blocks rounded-5 bg-secondary text-light mx-auto mt-5"> <h2 class="mx-auto mt-5">بلوک اول</h2> </div>
        <div class="col-xl-4 home-blocks rounded-5 bg-secondary text-light mx-auto mt-5"> <h2 class="mx-auto mt-5">بلوک دوم</h2> </div>
        <div class="col-xl-1 home-blocks rounded-5 bg-secondary text-light mx-auto mt-5"> <h2 class="mx-auto mt-5">بلوک سوم</h2> </div>
        <div class="col-xl-2 home-blocks rounded-5 bg-secondary text-light mx-auto mt-5"> <h2 class="mx-auto mt-5">بلوک چهارم</h2> </div>

    </div>


    <div class="home-tile row bg-success text-light text-center mx-2 rounded-5 my-5"><h2 class="mx-auto my-auto">نمادهای محصول</h2></div>

    <div class="home-tile row bg-primary text-light text-center mx-2 rounded-5 my-5"><h2 class="mx-auto my-auto">اسلایدر خدمات</h2></div>

    <div class="home-tile row bg-warning text-dark text-center mx-2 rounded-5 my-5"><h2 class="mx-auto my-auto">اسلایدر محصولات</h2></div>

    <div class="home-tile row bg-info text-dark text-center mx-2 rounded-5 my-5"><h2 class="mx-auto my-auto">اسلایدر مقالات</h2></div>

    <div class="row border text-center mx-2 rounded-5 my-5 px-1 py-2">


        @auth()
        <form wire:submit.prevent="saveMessage" class="row">


                <div class="row col-xl-6 mx-auto">

                    <div class="row my-4">

                        <div class="col-xl-1 text-xl-start"><label class="form-label" for="subject"> موضوع </label></div>
                        <div class="col-xl-11"><input type="text" class="form-control" id="subject" wire:model.blur="subject"></div>
                        @error('subject')<div class="text-danger">{{$message}}</div>@enderror

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <textarea rows="5" class="form-control h-auto" wire:model.blur="text"></textarea>
                            @error('text')<div class="text-danger">{{$message}}</div>@enderror
                        </div>
                    </div>

                    <div class="row my-4">

                        <div class="col-xl-2 text-xl-end">

                            <input type="file" id="files" wire:model="files" class="d-none" multiple>
                            <label for="files" class="btn btn-primary"> <i class="bi-upload"></i> </label>

                        </div>

                        <div class="col-xl-8 text-xl-end">
                            <label class="alert alert-secondary py-1">
                                @if (count($uploadedFiles))
                                    @foreach ($uploadedFiles as $file)
                                        <span class="badge bg-secondary me-1 m-2">{{ $file }}</span>
                                    @endforeach
                                @else
                                    {{ $uploadTip }}
                                @endif
                            </label>
                        </div>

                        <div class="col-xl-2 text-xl-start">
                            <button type="submit" class="cs-button ms-0 w-auto rounded-3 border-0 mx-auto py-2 px-3"> ارسال </button>
                        </div>
                    </div>

                    @error('files.*')
                    <div class="text-danger text-nowrap">{{ $message }}</div>
                    @enderror


                </div>
             </form>
            @endauth

                                                                            {{--  Guest user's  --}}


            @guest()

                    <form wire:submit.prevent="saveGuestMessage">

                    <div class="row col-xl-6 mx-auto">

                        <div class="row my-4">

                            <div class="col-xl-2 text-xl-center"><label class="form-label" for="name"> نام و نام خانوادگی </label></div>
                            <div class="col-xl-3"><input type="text" class="form-control" id="name" wire:model.blur="name"></div>
                            @error('name')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror

                            <div class="col-xl-1 text-xl-start"><label class="form-label" for="email"> ایمیل </label></div>
                            <div class="col-xl-3"><input type="text" class="form-control" id="email" wire:model.blur="email"></div>
                            @error('email')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror

                            <div class="col-xl-1 text-xl-start"><label class="form-label" for="phone"> شماره همراه </label></div>
                            <div class="col-xl-2"><input type="text" class="form-control" id="phone" wire:model.blur="phone"></div>
                            @error('phone')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror


                            <div class="col-xl-1 text-xl-start mt-3"><label class="form-label" for="subject"> موضوع </label></div>
                            <div class="col-xl-11 mt-3"><input type="text" class="form-control" id="subject" wire:model.blur="subject">
                            </div>
                            @error('subject')<small class="text-danger text-nowrap text-xl-end">{{$message}}</small>@enderror

                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <textarea rows="5" class="form-control h-auto" wire:model.blur="text"></textarea>
                                @error('text')<div class="text-danger">{{$message}}</div>@enderror
                            </div>
                        </div>

                        <div class="row my-4">

                            <div class="col-xl-2 text-xl-end">

                                <input type="file" id="files" wire:model="files" class="d-none" multiple>
                                <label for="files" class="btn btn-primary"> <i class="bi-upload"></i> </label>

                            </div>

                            <div class="col-xl-8 text-xl-end">
                                <label class="alert alert-secondary py-1">
                                    @if (count($uploadedFiles))
                                        @foreach ($uploadedFiles as $file)
                                            <span class="badge bg-secondary me-1 m-2">{{ $file }}</span>
                                        @endforeach
                                    @else
                                        {{ $uploadTip }}
                                    @endif
                                </label>
                            </div>

                            <div class="col-xl-2 text-xl-start">
                                <button type="submit" class="cs-button ms-0 w-auto rounded-3 border-0 mx-auto py-2 px-3"> ارسال </button>
                            </div>

                        </div>

                        @error('files.*')
                        <div class="text-danger text-nowrap">{{ $message }}</div>
                        @enderror

                    </div>


                 </form>

            @endguest

    </div>

</div>

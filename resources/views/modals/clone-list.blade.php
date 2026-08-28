<!-- Modal -->
<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header row">

                <div class="col-md-1 col-2 text-start">
                    <button type="button" class="btn-close me-0" wire:click="closeCloneList"></button>
                </div>
            </div>

            <div class="modal-body px-5">


            <div class="row">

                <div class="col-4 border">


                        <div class="dropdown mx-auto">

                            <button class="btn btn-secondary dropdown-toggle w-100 mx-auto" type="button" wire:click="$toggle('showCategoryList')">
                                {{$cloneCategoryName ?? 'انتخاب دسته'}}
                            </button>

                            @if($showCategoryList)
                                <div class="w-100 p-2">

                                    <input type="text" class="form-control mb-2" placeholder="جستجوی دسته..." wire:model.live="cloneCategorySearch">

                                    <div>
                                        @forelse($this->Categories as $category)
                                            <button class="dropdown-item" wire:click="chooseCategory({{$category->id}})">
                                                {{$category->name}}
                                            </button>

                                        @empty
                                            <button class="dropdown-item text-danger">
                                                دسته ای وجود ندارد
                                            </button>
                                        @endforelse
                                    </div>


                                </div>
                            @endif



                        </div>



                </div>

                <div class="col-4 border">


                        <div class="dropdown mx-auto" >

                            <button class="btn btn-secondary dropdown-toggle w-100 mx-auto" type="button" wire:click="$toggle('showProductList')">
                                {{$cloneProductName ?? 'انتخاب محصول'}}
                            </button>

                            @if($showProductList)
                                <div class="w-100 p-2">

                                    <input type="text" class="form-control mb-2" placeholder="جستجوی محصول..." wire:model.live="cloneProductSearch">

                                    <div>
                                        @forelse($this->Products as $product)
                                            <div class="dropdown-item" wire:click="chooseProduct({{$product->id}})">
                                                <div class="row d-flex border delete-badge">

                                                    <div class="col-auto overflow-hidden">
                                                        <img class="mx-auto" src="{{asset('storage/products/'.$product->image) }}" width="64"  alt="پیش نمایش">
                                                    </div>

                                                    <div class="col-9 text-end my-auto h4">{{$product->name}}</div>
                                                </div>
                                            </div>

                                        @empty
                                            <button class="dropdown-item text-danger text-center h3">
                                                هیچ محصولی وجود ندارد
                                            </button>
                                        @endforelse
                                    </div>


                                </div>
                            @endif


                        </div>



                </div>



                <div class="col-4 border">

                    @if($cloneProductName)
                        <div class="dropdown mx-auto" >

                            <button class="btn btn-secondary dropdown-toggle w-100 mx-auto" type="button" wire:click="$toggle('showTableList')">
                                انتخاب جدول
                            </button>

                            @if($showTableList)
                                <div class="w-100 p-2">

                                    <div>
                                        @forelse($this->CloneTable as $table)
                                            <button class="dropdown-item" wire:click="cloneProductTable({{$table->id}})">
                                                {{$table->name}}
                                            </button>

                                        @empty
                                            <button class="dropdown-item text-danger text-center h3">
                                                هیچ جدولی وجود ندارد
                                            </button>
                                        @endforelse
                                    </div>


                                </div>
                            @endif


                        </div>
                    @endif


                </div>




            </div>




            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" wire:click="closeCloneList">
                        بازگشت
                </button>
            </div>
        </div>
    </div>
</div>




<div>
    <form wire:submit.prevent="save" class="row border py-2">

        <div class="row my-3">
            @if($this->Filters->isNotEmpty())

                <select wire:model.live="filter_id" class="form-select col-xl-6">

                    <option value="">انتخاب برای فیلتر</option>
                    @foreach($this->Filters as $filter)
                        <option value="{{$filter->id}}">{{$filter->title}}</option>
                    @endforeach

                </select>

                <div class="col-xl-6 my-auto">
                    <label for="title"> عنوان </label>
                    <input type="text" id="title" class="form-control" wire:model.blur="title">
                    @error('title') <small> {{$message}} </small> @enderror
                </div>

            @else
                <div class="col-xl-12 my-auto">
                    <label for="title"> عنوان </label>
                    <input type="text" id="title" class="form-control" wire:model.blur="title">
                    @error('title') <small> {{$message}} </small> @enderror
                </div>
            @endif
        </div>

        <div class="row my-3">

            <div class="col-xl-3 my-auto">
                <label for="value"> مقدار </label>
                <input type="text" id="value" class="form-control" wire:model.blur="value">
                @error('value') <small> {{$message}} </small> @enderror
            </div>

            <div class="col-xl-1 my-auto text-center">
                <input type="radio" class="btn-check mx-3" id="btn-check-string-outlined" autocomplete="off" wire:model.live="type" value="string">
                <label class="btn btn-outline-success w-auto rounded-5 py-2" for="btn-check-string-outlined">متنی</label>
            </div>

            <div class="col-xl-1 my-auto text-center">
                <input type="radio" class="btn-check mx-3" id="btn-check-integer-outlined" autocomplete="off" wire:model.live="type" value="integer">
                <label class="btn btn-outline-primary w-auto rounded-5 py-2" for="btn-check-integer-outlined">عددی</label>
            </div>


            @if($type == 'integer')
                <div class="col-xl-1 my-auto">
                    <label for="suffix"> پسوند </label>
                    <input type="text" id="suffix" class="form-control" wire:model.live="suffix">
                    @error('suffix') <small> {{$message}} </small> @enderror
                </div>
                <div class="col-xl-3"></div>
            @else

                <div class="col-xl-4"></div>
            @endif





            <div class="col-xl-3 my-auto text-start">

                @if($this->editing)
                    <button type="button" class="btn btn-danger mx-3" wire:click="cancelGroup">انصراف</button>
                @endif

                <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
            </div>
        </div>


    </form>
</div>

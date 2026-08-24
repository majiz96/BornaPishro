<div>
    <form wire:submit.prevent="save" class="row border py-2">

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



        <div class="col-xl-4 my-auto">
            <label for="value"> مقدار </label>
            <input type="text" id="value" class="form-control" wire:model.blur="value">
            @error('value') <small> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-3 my-auto text-start">

            @if($this->editing)
                <button type="button" class="btn btn-danger mx-3" wire:click="cancelGroup">انصراف</button>
            @endif

            <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
        </div>
    </form>
</div>

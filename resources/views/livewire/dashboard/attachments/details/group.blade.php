<div>
    {{--  Specification Groups  --}}
    <form wire:submit.prevent="save" class="row border py-2">

        <div class="col-xl-1 my-auto"> <label for="group"> عنوان گروه </label> </div>

        <div class="col-xl-4 my-auto">
            <input type="text" id="group" class="form-control" wire:model.blur="name">
            @error('name') <small> {{$message}} </small> @enderror
        </div>

        <div class="col-xl-4"></div>


        <div class="col-xl-3 my-auto text-start">

            @if($this->editing)
                <button type="button" class="btn btn-danger mx-3" wire:click="cancelGroup">انصراف</button>
            @endif

            <button type="submit" class="btn btn-primary mx-3">ذخیره</button>
        </div>
    </form>
</div>

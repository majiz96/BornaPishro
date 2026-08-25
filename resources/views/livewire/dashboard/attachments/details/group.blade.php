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

    <div class="row d-flex border px-3 py-2">

        <div class="row text-center"> <h3> گروه ها ({{$table}}) </h3> </div>

        @forelse($this->groups as $group)

            <div class="col-auto mx-auto border rounded py-2 delete-badge text-center {{$active == $group->id ? 'bg-secondary' : ''}}"
                 wire:click="select({{$group->id}})">

                <div class="col-12 mx-auto text-center pb-1">{{$group->title}}</div>

                <div class="btn-group" dir="ltr">

                    <button class="btn btn-sm btn-group btn-danger"
                            wire:confirm="آیا از حذف گروه ({{$group->name}}) و محتویات آن مطمئن هستید؟"
                            wire:click="delete({{$group->id}})">
                        حذف
                    </button>

                    <button class="btn btn-sm btn-group btn-warning"
                            wire:click="makeGroupEmpty({{$group->id}})"
                            wire:confirm="آیا از تخلیه و پاک کردن محتویات ({{$group->name}}) مطمئن هستید؟">
                    تخلیه
                    </button>

                    <button class="btn btn-sm btn-group btn-primary" wire:click="edit({{$group->id}})">ویرایش</button>
                </div>
            </div>

        @empty

            <div class="row text-center text-danger"> <h5> هیچ گروهی ثبت نشده است </h5> </div>

        @endforelse

    </div>


</div>

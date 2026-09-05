<?php

namespace App\Observers;

use App\Models\Field;
use Illuminate\Support\Facades\Cache;

class FieldObserver
{
    /**
     * Handle the Field "created" event.
     */
    public function created(Field $field): void
    {
        //
        Cache::forget('website-fields');
        Cache::forget('menu-fields');
        Cache::forget("current-field-{$field->id}");
        Cache::forget("menu-categories-{$field->id}");
    }

    /**
     * Handle the Field "updated" event.
     */
    public function updated(Field $field): void
    {
        //
        Cache::forget('website-fields');
        Cache::forget('menu-fields');
        Cache::forget("current-field-{$field->id}");
        Cache::forget("menu-categories-{$field->id}");
    }

    /**
     * Handle the Field "deleted" event.
     */
    public function deleted(Field $field): void
    {
        //
        Cache::forget('website-fields');
        Cache::forget('menu-fields');
        Cache::forget("current-field-{$field->id}");
        Cache::forget("menu-categories-{$field->id}");
    }

    /**
     * Handle the Field "restored" event.
     */
    public function restored(Field $field): void
    {
        //
    }

    /**
     * Handle the Field "force deleted" event.
     */
    public function forceDeleted(Field $field): void
    {
        //
    }
}

<?php

namespace App\Jobs;

use App\Mail\NoticeMail;
use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable as FoundationQueueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Mail;

class NoticeMailJob implements ShouldQueue
{
    use FoundationQueueable;

    public int $backoff = 30;

    public int $tries = 5;

    public function __construct(public Notice $notice, public string $email)
    {
        //
    }

    public function middleware(): array
    {
        return [
            new RateLimited('emails'),
        ];
    }

    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new NoticeMail($this->notice));
    }
}

<x-layouts.app>
    <div class="container mt-5 avoid-emptiness">
        <div class="alert alert-info">
            لطفاً ایمیل خود را بررسی کنید. لینک تأیید برایتان ارسال شده است.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                لینک تأیید جدید به ایمیل شما ارسال شد.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">ارسال دوباره لینک تأیید</button>
        </form>
    </div>
</x-layouts.app>

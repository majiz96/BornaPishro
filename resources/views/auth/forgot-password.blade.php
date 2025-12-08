<x-layout.app>
    <div class="container mt-5">
        <h3>فراموشی رمز عبور</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary">ارسال لینک بازیابی</button>
        </form>
    </div>
</x-layout.app>

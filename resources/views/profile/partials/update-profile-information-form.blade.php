<section>
    <header class="mb-4">
        <h2 class="h4 text-dark">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 alert alert-warning p-2">
                    <p class="mb-1">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-link p-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 mb-0 text-success small">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <div id="saved-msg" class="text-success small" role="alert">
                    {{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const savedMsg = document.getElementById('saved-msg');
        if (savedMsg) {
            setTimeout(() => {
                savedMsg.style.display = 'none';
            }, 2000);
        }
    });
</script>

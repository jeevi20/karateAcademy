@extends('layouts.admin.master')

@section('content')
<div class="container py-4">
    <div class="card shadow mb-4 mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <p class="mb-4 text-muted small">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                           class="form-control @error('password') is-invalid @enderror" autofocus>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

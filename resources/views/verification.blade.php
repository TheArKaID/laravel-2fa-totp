@extends('layouts.app')

@section('title', 'Verification Page')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Verification') }}</h1>
        </div>

        <div class="section-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('Please Verify') }}

            <div class="card mt-4">
                <div class="card-header">
                    Verify OTP
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('2fa.verify') }}">
                        @csrf
                        <div class="form-group">
                            <label for="otp">One-Time Password</label>
                            <input type="text" name="otp" id="otp" class="form-control @error('otp') is-invalid @enderror" required>
                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Verify 2FA</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

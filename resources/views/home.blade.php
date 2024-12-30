@extends('layouts.app')

@section('title', 'Blank Page')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Dashboard') }}</h1>
        </div>

        <div class="section-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}

            <div class="card mt-4">
                <div class="card-header">
                    Scan the QR Code with your Authenticator App
                </div>
                <div class="card-body text-center">
                    <img src="{{ $qrCode }}" alt="QR Code">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

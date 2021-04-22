@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('admin.auth', $userAdmin) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="privateKey"
                                class="col-md-4 col-form-label text-md-right">{{ __('Private Key') }}</label>
                            <div class="col-md-6">
                                <input id="privateKey" type="password"
                                    class="form-control @error('WrongCredentials') is-invalid @enderror"
                                    name="privateKey" required autocomplete="current-privateKey">
                                @error('WrongCredentials')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Access') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
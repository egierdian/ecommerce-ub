@extends('cms.layouts.app')

@section('content')
<div class="container container-login animated fadeIn">
	<div class="text-center mb-4">
        <a href="{{route('frontend.index')}}">
		<img class="mx-auto" src="{{asset('assets/img/icon-ubakrie.png')}}" width="110" alt="">
        </a>
        <br>
		<span class="text-muted mt-2">Daftar E-Commerce UBakrie</span>
	</div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="login-form">
            <div class="form-group form-floating-label">
                <input  id="name" name="name" type="text" class="form-control input-border-bottom" autocomplete="name" value="{{ old('name')}}" required>
                <label for="name" class="placeholder">Nama Lengkap</label>
                @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group form-floating-label">
                <input  id="email" name="email" type="email" class="form-control input-border-bottom" value="{{ old('email')}}" autocomplete="email" required>
                <label for="email" class="placeholder">Email</label>
                @error('email')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group form-floating-label">
                <input  id="phone" name="phone" type="number" class="form-control input-border-bottom" value="{{ old('phone')}}" required>
                <label for="phone" class="placeholder">No. Telepon (0812323xxx)</label>
                @error('phone')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group form-floating-label">
                <input  id="password" name="password" type="password" class="form-control input-border-bottom" required>
                <label for="password" class="placeholder">Password</label>
                <div class="show-password">
                    <i class="icon-eye"></i>
                </div>
                @error('password')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group form-floating-label">
                <input  id="password-confirm" name="password_confirmation" type="password" class="form-control input-border-bottom" required>
                <label for="password-confirm" class="placeholder">Konfirmasi Password</label>
                <div class="show-password">
                    <i class="icon-eye"></i>
                </div>
                @error('password')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="row form-sub m-0" style="display: none;">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                    <label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
                </div>
            </div>
            <div class="form-action">
                <a href="{{route('login')}}" id="show-signin" class="btn btn-primary btn-link btn-login mr-3">Login</a>
                <button type="submit" class="btn btn-primary btn-rounded btn-login">Daftar</button>
            </div>
        </div>
    </form>
</div>
@endsection

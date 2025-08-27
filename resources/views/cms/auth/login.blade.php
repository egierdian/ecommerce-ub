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
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
			<div class="login-form">
				@if (\Session::has('success'))
					<div class="alert alert-success" role="alert">
						Pendaftaran Berhasil, silahkan login 
					</div>
				@endif
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="text" autocomplete="off" class="form-control input-border-bottom" value="{{ old('email')}}" required autofocus>
					<label for="email" class="placeholder">Email</label>
                    @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" autocomplete="off" class="form-control input-border-bottom" required>
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
                    @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
				</div>
				<div class="form-group form-floating-label">
				</div>
				<div class="form-action mb-3">
					<button type="submit" class="btn btn-primary btn-rounded btn-login">Masuk</button>
				</div>
				<div class="login-account">
					<span class="msg">Belum punya akun ?</span>
					<a href="{{route('register')}}" id="show-signup" class="link">Daftar</a>
				</div>
			</div>

    </form>    
</div>
@endsection

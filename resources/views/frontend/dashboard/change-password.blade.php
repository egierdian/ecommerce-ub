@extends('frontend.dashboard.master')

@section('title', 'Ubah Password')

@section('dashboard-content')

<div>
    @if(session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center" id="successAlert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h4>Ubah Password</h4>
    <form action="{{route('frontend.dashboard.update-password')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('current_password') has-error @enderror">
                                    <label>Password Lama <span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" class="form-control">
                                    @error('current_password')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('password') has-error @enderror">
                                    <label>Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('password_confirmation') has-error @enderror">
                                    <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                    @error('password_confirmation')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-border px-5" id="btnSave">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@extends('cms.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
</style>
<div class="page-inner">
    @if(session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center" id="successAlert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <form action="{{isset($data) ? route('admin.category.update', ['id'=>$data->id]) : route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Create' }} Category</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('name') has-error @enderror">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ isset($data) ? $data->name : old('name') }}">
                                    @error('name')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('image') has-error @enderror">
                                    <label>Image <span class="text-danger"></span></label>
                                    <input type="file" class="form-control" name="image" multiple>
                                    @error('image')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror

                                    @if(isset($data->image) && $data->image) 
                                    <a href="{{ asset($data->image) }}" class="btn btn-link btn-primary btn-sm image-popup" data-original-title="Lihat">
                                        <img class="img-fluid" alt="" src="{{ asset($data->image) }}" width="55" style="display:none">
                                        Lihat
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-right">
                        <a href="{{route('admin.category')}}" class="btn btn-info">Back</a>
                        <button type="submit" class="btn btn-primary btn-border px-5" id="btnSave">{{isset($data) ? 'Update' : 'Submit'}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{asset('assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.image-popup').magnificPopup({
            type: 'image'
        });
    })
</script>
@endsection
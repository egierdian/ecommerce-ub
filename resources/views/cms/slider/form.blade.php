@extends('cms.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ isset($data) ? 'Edit' : 'Create' }} Slider</h4>
    </div>
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
    <form action="{{isset($data) ? route('admin.slider.update', ['id'=>$data->id]) : route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('title') has-error @enderror">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input name="title" class="form-control" value="{{ isset($data) ? $data->title : old('title') }}">
                                    @error('title')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('url') has-error @enderror">
                                    <label>URL <span class="text-danger">*</span></label>
                                    <input name="url" class="form-control" value="{{ isset($data) ? $data->url : old('url') }}">
                                    @error('url')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('description') has-error @enderror">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control">{{ isset($data) ? $data->description : old('description') }}</textarea>
                                    @error('description')
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
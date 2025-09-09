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
    <form action="{{isset($data) ? route('admin.faq.update', ['id'=>$data->id]) : route('admin.faq.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Create' }} FAQ</h4>
                        </div>
                    </div>
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
                                <div class="form-group @error('description') has-error @enderror">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control"> {{ isset($data) ? $data->description : old('description') }} </textarea>
                                    @error('description')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('order') has-error @enderror">
                                    <label>Order <span class="text-danger">*</span></label>
                                    <input type="number" name="order" class="form-control" value="{{ isset($data) ? $data->order : old('order') }}">
                                    @error('order')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-right">
                        <a href="{{route('admin.faq')}}" class="btn btn-info">Back</a>
                        <button type="submit" class="btn btn-primary btn-border px-5" id="btnSave">{{isset($data) ? 'Update' : 'Submit'}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#description').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    })
</script>
@endsection
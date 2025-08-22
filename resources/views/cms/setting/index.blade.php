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
    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach($settings as $setting)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ucwords( str_replace('_', ' ',$setting->id))}} <span class="text-danger">*</span></label>
                                    <input type="hidden" name="id[]" value="{{$setting->id}}">
                                    @if($setting->type == 'textarea')
                                    <textarea name="value[]" class="form-control">{{$setting->value}}</textarea>
                                    @else
                                    <input type="{{$setting->type}}" name="value[]" class="form-control" value="{{$setting->value}}">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-action text-right">
                        <button type="submit" class="btn btn-primary btn-border px-5" id="btnSave">Update</button>
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
    })
</script>
@endsection
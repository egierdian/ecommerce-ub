@extends('cms.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ isset($data) ? 'Edit' : 'Create' }} Product</h4>
    </div>
    <form action="{{isset($data) ? route('admin.product.update', ['id'=>$data->id]) : route('admin.product.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @error('name') has-error @enderror">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ isset($data) ? $data->name : old('name') }}">
                                    @error('name')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('type') has-error @enderror">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select name="type" class="form-control">
                                        @foreach($type as $k => $v)
                                        <option value="{{$k}}" {{ (isset($data) ? $data->type : old('type')) == $k ? 'selected' : '' }}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 view-type view-product">
                                <div class="form-group @error('price') has-error @enderror">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="text" name="price" class="form-control" value="{{ isset($data) ? $data->price : old('price') }}">
                                    @error('price')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 view-type view-sewa">
                                <div class="form-group @error('base_price_per_hour') has-error @enderror">
                                    <label>Base Price per Hour <span class="text-danger">*</span></label>
                                    <input type="text" name="base_price_per_hour" class="form-control" value="{{ isset($data) ? $data->base_price_per_hour : old('base_price_per_hour') }}">
                                    @error('base_price_per_hour')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 view-type view-sewa">
                                <div class="form-group @error('holiday_price_per_hour') has-error @enderror">
                                    <label>Holiday Price per Hour <span class="text-danger">*</span></label>
                                    <input type="text" name="holiday_price_per_hour" class="form-control" value="{{ isset($data) ? $data->holiday_price_per_hour : old('holiday_price_per_hour') }}">
                                    @error('holiday_price_per_hour')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('description') has-error @enderror">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control"> {{ isset($data) ? $data->description : old('description') }} </textarea>
                                    @error('description')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-right">
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
        checkType()

        $("[name=type]").on("change", function() {
            checkType()
        })
    })


    function checkType() {
        let type = $("[name=type]").val()
        $('.view-type').show()
        if (type == '1') {
            $('.view-product').hide()
        } else {
            $('.view-sewa').hide()
        }
    }
</script>
@endsection
@extends('cms.layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
<style>
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ isset($data) ? 'Edit' : 'Create' }} Rental Price</h4>
    </div>
    <form action="{{isset($data) ? route('admin.rental-price.update', ['id'=>$data->id]) : route('admin.rental-price.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('product') has-error @enderror">
                                    <label>Product <span class="text-danger">*</span></label>
                                    <select name="product" class="form-control">
                                        @foreach($products as $k => $v)
                                        <option value="{{$v->id}}" {{ (isset($data) ? $data->product_id : old('product')) == $v->id ? 'selected' : '' }}>{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('date') has-error @enderror">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ isset($data) ? $data->date : old('date') }}">
                                    @error('date')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('spesial_price') has-error @enderror">
                                    <label>Spesial Price <span class="text-danger">*</span></label>
                                    <input type="text" name="spesial_price" class="form-control format-number" value="{{ isset($data) ? $data->spesial_price : old('spesial_price') }}">
                                    @error('spesial_price')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-right">
                        <a href="{{route('admin.rental-price')}}" class="btn btn-info">Back</a>
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
    })
</script>
@endsection
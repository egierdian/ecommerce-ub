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
    <form action="{{isset($data) ? route('admin.product.update', ['id'=>$data->id]) : route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Create' }} Product</h4>
                        </div>
                    </div>
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
                            <div class="col-md-12">
                                <div class="form-group @error('category') has-error @enderror">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control">
                                        @foreach($categories as $k => $v)
                                        <option value="{{$v->id}}" {{ (isset($data) ? $data->category_id : old('category')) == $v->id ? 'selected' : '' }}>{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 view-type view-product">
                                <div class="form-group @error('price') has-error @enderror">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="text" name="price" class="form-control format-number" value="{{ isset($data) ? $data->price : old('price') }}">
                                    @error('price')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 view-type view-product">
                                <div class="form-group @error('qty') has-error @enderror">
                                    <label>Qty <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control" value="{{ isset($data) ? $data->qty : old('qty') }}">
                                    @error('qty')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 view-type view-sewa">
                                <div class="form-group @error('base_price_per_hour') has-error @enderror">
                                    <label>Base Price per Hour <span class="text-danger">*</span></label>
                                    <input type="text" name="base_price_per_hour" class="form-control format-number" value="{{ isset($data) ? $data->base_price_per_hour : old('base_price_per_hour') }}">
                                    @error('base_price_per_hour')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 view-type view-sewa">
                                <div class="form-group @error('holiday_price_per_hour') has-error @enderror">
                                    <label>Holiday Price per Hour <span class="text-danger">*</span></label>
                                    <input type="text" name="holiday_price_per_hour" class="form-control format-number" value="{{ isset($data) ? $data->holiday_price_per_hour : old('holiday_price_per_hour') }}">
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
                                    <textarea name="description" id="description" class="form-control"> {{ isset($data) ? $data->description : old('description') }} </textarea>
                                    @error('description')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('images') has-error @enderror">
                                    <label>Images <span class="text-danger"></span></label>
                                    <input type="file" class="form-control" name="images[]" multiple>
                                    @error('images')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if (count($images) > 0)
                                    <div class="w-100 d-flex">
                                        <button type="button" class="btn btn-sm btn-danger" data-id={{encrypt($data->id)}} data-type="all" onclick="deleteImage(this)">Hapus semua</button>
                                    </div>
                                    @foreach($images as $img)
                                    <div class="w-100 d-flex align-items-center">
                                        <p class="m-0">{{$img->name}}</p>
                                        <div class="form-button-action">
                                            <a href="{{ asset($img->path) }}" class="btn btn-link btn-primary btn-sm image-popup" data-original-title="Lihat">
                                                <img class="img-fluid" alt="" src="{{ asset($img->path) }}" width="55" style="display:none">
                                                <i class="fa fa-eye"></i>
                                            </a>
											<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-sm btn-danger" data-id={{encrypt($data->id)}} data-imageid="{{$img->id}}" data-name="{{$img->name}}" data-type="single" onclick="deleteImage(this)">
												<i class="fa fa-times"></i>
											</button>
										</div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-right">
                        <a href="{{route('admin.product')}}" class="btn btn-info">Back</a>
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
        checkType()

        $("[name=type]").on("change", function() {
            checkType()
        })

        $('.image-popup').magnificPopup({
            type: 'image'
        });
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

    function deleteImage(e) {
        let images = $(e).data()
        
        let id = images.id
        let type = images.type
        let title = 'Hapus semua'
        let imageId = null 
        let name = null
        if(type != 'all') {
            name = images.name
            title = `Hapus ${images.name}`
            imageId = images.imageid
        }

        Swal.fire({
            title: title,
            text: "Apakah kamu yakin hapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                if(type != 'all') {
                    window.location.href = `/admin/product/delete-image/${id}/${imageId}`
                } else {
                    window.location.href = `/admin/product/delete-image/${id}`
                }
            }
        });
    }
</script>
@endsection
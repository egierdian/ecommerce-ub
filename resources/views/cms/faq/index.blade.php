@extends('cms.layouts.master')

@section('content')
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">FAQ</h4>
                        <a href="{{ route('admin.faq.create') }}" class="btn btn-info btn-sm ml-auto">Create</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-data">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 100px;">No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        loadData()
        $('.filter-data').change(function() {
            $('#table-data').DataTable().destroy();
            loadData()
        })
    });

    function loadData(){
        $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ route('admin.faq') }}`,
                data: {
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title',
                    searchable: true
                },
                {
                    data: 'order',
                    name: 'order',
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ]
        });
    }
</script>
@endsection
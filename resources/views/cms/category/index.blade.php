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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center mb-1">
                                <div class="page-header">
                                    <h4 class="page-title">Category</h4>
                                </div>
								<a href="{{ route('admin.category.create') }}" class="btn btn-info btn-md mb-3 ml-auto">Create</a>
							</div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mt-3" id="table-data">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 100px;">No</th>
                                    <th scope="col">Name</th>
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
                url: `{{ route('admin.category') }}`,
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
                    data: 'name',
                    name: 'name',
                    searchable: true
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
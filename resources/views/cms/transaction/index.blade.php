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
                        <h4 class="card-title">Transaction</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-data">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 100px;">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Bukti Bayar</th>
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
<script src="{{asset('assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script>
    $(document).ready(function() {
        loadData()
        $('.filter-data').change(function() {
            $('#table-data').DataTable().destroy();
            loadData()
        })

        $('.image-popup').magnificPopup({
            type: 'image'
        });
    });

    function loadData() {
        $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ route('admin.transaction') }}`,
                data: {},
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'code',
                    name: 'code',
                    searchable: true
                },
                {
                    data: 'customer',
                    name: 'customer',
                    searchable: true
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: true
                },
                {
                    data: 'total',
                    name: 'total',
                    searchable: true
                },
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
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

    function approval(e) {
        let id = $(e).data('id');
        let code = $(e).data('code');
        let status = $(e).data('status');

        let actionText = '';
        if (status == 2) {
            actionText = 'Approve';
        } else if (status == 3) {
            actionText = 'Reject';
        }

        Swal.fire({
            title: `${actionText} ${code}?`,
            text: `Apakah kamu yakin ingin ${actionText.toLowerCase()} transaksi ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ' + actionText,
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/transaction/approval/${id}?status=${status}`;
            }
        });
    }
</script>
@endsection
@extends('frontend.dashboard.master')

@section('title', 'Pesanan Saya')

@section('dashboard-content')

<div>
    @if(session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center" id="successAlert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center" id="errorAlert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h4>Riwayat Pesanan</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Bukti Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trans)
                <tr>
                    <td>{{$trans->code}}</td>
                    <td>{{date('d M Y', strtotime($trans->created_at))}}</td>
                    <td>
                        {!! paymentStatusBadge($trans->status) !!}
                    </td>
                    <td>Rp {{number_format($trans->total, 0, ',', '.')}}</td>
                    <td>
                        @if($trans->file)
                        <a href="{{asset($trans->file)}}" target="_blank">Lihat</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('frontend.invoice', ['code' => $trans->code])}}" class="btn btn-sm btn-primary" target="_blank">Invoice</a>
                        @if($trans->status == 1)
                        <button class="btn btn-sm btn-info text-white" data-id="{{encrypt($trans->id)}}" onclick="showModalUpload(this)">Upload Bukti Bayar</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalUploadLabel">Upload Bukti Bayar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formUpload" action="{{ route('frontend.dashboard.payment.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">
            <div class="mb-3">
                <label for="file" class="form-label">Bukti Bayar (Image)</label>
                <input type="file" class="form-control" name="file" id="file" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="remark" class="form-label">Catatan</label>
                <textarea class="form-control" name="remark" id="remark" rows="3" required></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="formUpload" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>

@endsection
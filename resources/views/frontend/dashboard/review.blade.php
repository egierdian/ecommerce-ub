@extends('frontend.dashboard.master')

@section('title', 'Produk Terbeli')

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
    <h4 class="mb-3">Penilaian</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatableCustomer">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Tanggal Review</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    <td>{{ $item['product']->name }}</td>
                    <td>
                        @if($item['rating'])
                            @for ($i = 1; $i <= 5; $i++)
                            @if($i <=$item['rating'])
                            <i class="fas fa-star text-warning"></i>
                            @else
                            <i class="far fa-star text-warning"></i>
                            @endif
                            @endfor
                        @else
                            <span class="text-muted">Belum ada penilaian</span>
                        @endif
                    </td>
                    <td>{{ $item['review'] ?? '-' }}</td>
                    <td>
                        {{ $item['review_date'] ? \Carbon\Carbon::parse($item['review_date'])->format('d M Y') : '-' }}
                    </td>
                    <td>
                        @if($item['review_id'])
                        @else
                        <button type="button" class="btn btn-sm btn-success btn-review"
                            data-product-id="{{ $item['product']->id }}"
                            data-product-name="{{ $item['product']->name }}"> Beri Penilaian
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Tunggal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reviewForm" action="{{route('frontend.dashboard.review.store')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Beri Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id">

                    <!-- Rating -->
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select" required>
                            <option value="">Pilih rating</option>
                            <option value="1">1 ⭐</option>
                            <option value="2">2 ⭐⭐</option>
                            <option value="3">3 ⭐⭐⭐</option>
                            <option value="4">4 ⭐⭐⭐⭐</option>
                            <option value="5">5 ⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>

                    <!-- Komentar -->
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Kirim Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
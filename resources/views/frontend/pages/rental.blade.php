@extends('frontend.layouts.master')

@section('title', 'Sewa')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('content')

<section class="bg-light py-5">
    <div class="container-fluid">
        <div class="text-center">

            <h1 class="display-5 fw-bold text-primary">Sewa</h1>
        </div>
        {{-- Form Filter Tanggal & Jam --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <p class="m-0">📅 Periksa jadwal ketersediaan sebelum melakukan pemesanan.</p>
                <form class="row g-3 align-items-end" id="#filterForm">
                    <div class="col-md-5">
                        <label for="start_datetime" class="form-label fw-semibold small text-muted">Mulai</label>
                        <input type="text" id="start_datetime" name="start_datetime"
                            class="form-control rounded-3"
                            placeholder="Pilih tanggal & jam mulai"
                            value="{{ request('start_datetime') }}">
                    </div>
                    <div class="col-md-5">
                        <label for="end_datetime" class="form-label fw-semibold small text-muted">Selesai</label>
                        <input type="text" id="end_datetime" name="end_datetime"
                            class="form-control rounded-3"
                            placeholder="Pilih tanggal & jam selesai"
                            value="{{ request('end_datetime') }}">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn btn-primary rounded-3 fw-semibold" id="buttonFilter">
                            <i class="fa fa-search me-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid Produk --}}
        <div id="rentProducts">
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#buttonFilter').on('click', function(e) {
      let start = $('#start_datetime').val();
      let end = $('#end_datetime').val();
      $.ajax({
        url: "{{ route('frontend.product.rental.search') }}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          start_datetime: start,
          end_datetime: end
        },
        beforeSend: function() {
          // tampilkan loading
          $('#rentProducts').html(`
            <div class="text-center w-100 py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p class="mt-2">Sedang memuat produk...</p>
            </div>
          `);
        },
        success: function(res) {
          let html = '';
          if (res.data.length > 0) {
            $.each(res.data, function(i, product) {
              console.log(product)
              html += `
                          <div class="col">
                            <div class="product-item h-100 d-flex flex-column">
                              <figure>
                                <a href="/product/${product.category.slug}/${product.slug}?param=${res.param}" title="${product.name}">
                                  <img src="/${product.first_image?.path ?? ''}" class="tab-image" width="100%">
                                </a>
                              </figure>
                              <h3>${product.name}</h3>
                              <span class="product-category">${product.type == 1 ? 'Sewa' : 'Produk'} - ${product.category.name}</span>
                              <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                <span class="price">Rp. ${Number(product.type == 1 ? product.base_price_per_hour : product.price).toLocaleString('id-ID')}</span>
                                <a href="/product/${product.category.slug}/${product.slug}?param=${res.param}" class="btn btn-primary btn-sm mt-2 rounded-3 w-100 fw-semibold">Sewa</a>
                              </div>
                            </div>
                          </div>`;
            });
            html = `<div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">${html}</div`
          } else {
            html = `<p class="text-muted text-center">Tidak ada produk tersedia di jam tersebut.</p>`;
          }
          $('#rentProducts').html(html);
        },
        error: function(err) {
          console.error(err);
          alert("Terjadi kesalahan saat mencari produk.");
        }
      })
    });
  })
  let startPicker, endPicker;

  startPicker = flatpickr("#start_datetime", {
    enableTime: true,
    time_24hr: true,
    minuteIncrement: 60, // hanya jam bulat
    dateFormat: "Y-m-d H:i",
    minDate: "today", // tidak boleh backdate
    minTime: "08:00",
    maxTime: "16:00",
    disableMobile: true,
    onChange: function(selectedDates) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      if (selectedDates.length > 0) {
        const start = selectedDates[0];

        // atur minDate di endPicker sesuai start
        endPicker.set("minDate", start);

        // kalau end sudah ada, tapi tidak valid, clear
        const endDate = endPicker.selectedDates[0];
        if (endDate) {
          if (
            start.toDateString() === endDate.toDateString() &&
            endDate.getHours() <= start.getHours()
          ) {
            endPicker.clear();
          }
        }
      }
    }
  });

  endPicker = flatpickr("#end_datetime", {
    enableTime: true,
    time_24hr: true,
    minuteIncrement: 60,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
    minTime: "08:00",
    maxTime: "17:00",
    disableMobile: true,
    onOpen: function(selectedDates, dateStr, instance) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      const start = startPicker.selectedDates[0];
      if (start) {
        // kalau tanggal end == start → jam akhir harus > jam awal
        instance.set("minDate", start);

        if (instance.selectedDates.length > 0 &&
          instance.selectedDates[0].toDateString() === start.toDateString()) {
          instance.set("minTime", (start.getHours() + 1).toString().padStart(2, '0') + ":00");
        } else {
          instance.set("minTime", "08:00");
        }
      }
    },
    onChange: function(selectedDates, dateStr, instance) {
      $('.flatpickr-minute, .flatpickr-hour').prop('readonly', true)
      const start = startPicker.selectedDates[0];
      if (start && selectedDates.length > 0) {
        const end = selectedDates[0];

        if (start.toDateString() === end.toDateString()) {
          instance.set("minTime", (start.getHours() + 1).toString().padStart(2, '0') + ":00");
        } else {
          instance.set("minTime", "08:00");
        }
      }
    }
  });
</script>
@endsection
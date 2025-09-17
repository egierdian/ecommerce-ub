@extends('frontend.layouts.master')

@section('title', 'Tentang kami')

@section('style')
<style>
    .textLayer span {
        position: absolute;
        white-space: pre;
        cursor: text;
        transform-origin: 0% 0%;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container text-center">
        <div style="text-align:center; margin-bottom:10px;">
            <button id="prev-page" class="btn btn-sm">⬅ Prev</button>
            <span>Page <span id="page-num"></span> of <span id="page-count"></span></span>
            <button id="next-page" class="btn btn-sm">Next ➡</button>
        </div>
        <div id="pdf-viewer"
            style="height:90vh; overflow-y:auto; background:#e5e5e5; padding:20px;">
        </div>

        <div style="text-align:center; margin-top:10px;">
            <button id="zoom-out" class="btn btn-sm">➖ Zoom Out</button>
            <span id="zoom-level">120%</span>
            <button id="zoom-in" class="btn btn-sm">➕ Zoom In</button>
        </div>
    </div>
</section>
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
    const url = "{{ route('pdf.view', ['product_id' => encrypt($product->id)]) }}";

    let pdfDoc = null;
    let currentPage = 1;
    let currentScale = 1.2;

    // Render semua halaman
    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(function(page) {
            const viewport = page.getViewport({
                scale: currentScale
            });

            const container = document.getElementById('pdf-viewer');
            container.innerHTML = ''; // hapus render lama

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            console.log(viewport.height)
            console.log(viewport.width)
            canvas.style.boxShadow = "0 4px 12px rgba(0,0,0,0.3)";
            canvas.style.background = "#fff";
            canvas.style.borderRadius = "4px";

            page.render({
                canvasContext: context,
                viewport: viewport
            });

            container.appendChild(canvas);

            // Update info halaman
            document.getElementById('page-num').textContent = pageNum;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            document.getElementById('zoom-level').textContent = Math.round(currentScale * 100) + "%";
        });
    }

    // Load PDF
    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        pdfDoc = pdf;
        renderPage(currentPage);
    });

    // Navigasi halaman
    document.getElementById('prev-page').addEventListener('click', function() {
        if (currentPage <= 1) return;
        currentPage--;
        renderPage(currentPage);
    });

    document.getElementById('next-page').addEventListener('click', function() {
        if (currentPage >= pdfDoc.numPages) return;
        currentPage++;
        renderPage(currentPage);
    });

    // Zoom controls
    document.getElementById('zoom-in').addEventListener('click', function() {
        currentScale += 0.2;
        renderPage(currentPage);
    });

    document.getElementById('zoom-out').addEventListener('click', function() {
        if (currentScale > 0.4) {
            currentScale -= 0.2;
            renderPage(currentPage);
        }
    });
</script>

@endsection
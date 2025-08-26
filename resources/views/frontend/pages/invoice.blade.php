@extends('frontend.layouts.master')

@section('style')
<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        background: #fff;
        border: 1px solid #eee;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 24px;
        color: #222;
    }

    .header .company {
        text-align: right;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    .summary td {
        font-weight: bold;
        background: #fafafa;
    }

    .summary .total td {
        font-size: 18px;
        color: #000;
        background: #f0f0f0;
    }
    .item-price{
        text-align: right;
    }
</style>
@endsection

@section('content')

<section class="py-3">
    <div class="container-fluid">

        <div class="invoice-box">
            <div class="header">
                <div>
                    <h1>INVOICE</h1>
                    <p>No: {{$invoice->code}}<br>Tanggal: {{date('d M Y', strtotime($invoice->created_at))}}</p>
                </div>
                <div class="company">
                    <strong>{{$webSettings['title_website'] ?? ''}}</strong><br>
                    {{$webSettings['address'] ?? ''}} <br />
                    Email: {{$webSettings['contact_email'] ?? ''}}
                </div>
            </div>

            <p><strong>Kepada:</strong><br>
                {{$invoice->name}}<br>
                {{$invoice->address}}<br>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th class="item-price">Harga</th>
                        <th class="item-price">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($invoice->transactionItems as $item)
                    @php $subtotal += $item->subtotal; @endphp
                    <tr>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->qty}}</td>
                        <td class="item-price">Rp {{number_format($item->price, 0, ',', '.')}}</td>
                        <td class="item-price">Rp {{number_format($item->subtotal, 0, ',', '.')}}</td>
                    </tr>
                    @endforeach
                    <tr class="summary">
                        <td colspan="3" class="item-price">Subtotal</td>
                        <td class="item-price">Rp {{number_format($subtotal, 0, ',', '.')}}</td>
                    </tr>
                    <tr class="summary">
                        <td colspan="3" class="item-price">Ongkos Kirim</td>
                        <td class="item-price">Rp 20.000</td>
                    </tr>
                    <tr class="summary total">
                        <td colspan="3" class="item-price">Total</td>
                        <td class="item-price">Rp {{number_format($subtotal + 20000, 0, ',', '.')}}</td>
                    </tr>
                </tbody>
            </table>

            <p style="margin-top:30px; font-size: 14px; text-align: center; color: #666;">
                Terima kasih telah berbelanja di toko kami 💙<br>
                Pembayaran dapat dilakukan melalui transfer ke rekening yang tertera pada email konfirmasi.
            </p>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        console.log('test')
    })
</script>
@endsection
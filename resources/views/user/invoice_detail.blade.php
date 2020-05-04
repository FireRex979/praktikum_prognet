@extends('layouts.user')
@section('judul','User | Invoice Page')
@section('content')
    <div class="breadcumb_area bg-img" style="background-image: url(assets/user/img/bg-img/breadcumb.jpg); margin-top: 5%">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Invoice</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout_area section-padding-100">
        <div class="container">
            <?php $total = 0; ?>
            <?php $qty = 0; ?>
            <?php $weight = 0; ?>
            @foreach($products as $product)
            <div class="row">
    		<div class="col-12 col-md-6 col-lg-12 ml-lg-center">
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading">
                            <h5>Produk {{$loop->iteration}}</h5>
                            <p>Detail</p>
                        </div>

                        <ul class="order-details-form mb-4">
                            <li><span>Nama Produk</span> <span>{{$product->product_name}}</span></li>
                            <li><span>Jumlah</span> <span>{{$product->qty}}</span></li>
                            <li><span>Harga</span> <span>Rp. {{$product->selling_price}}</span></li>
                            <li><span>Diskon</span> <span>{{$product->discount}}%</span></li>
                            <li><span>Berat per item</span> <span>{{$product->weight}} gram</span></li>
                            <?php 
                                $subtotal = ($product->selling_price-$product->selling_price*$product->discount/100)*$product->qty;
                                $total = $total+$subtotal;
                                $qty = $qty+$product->qty;
                                $weight = $weight+$product->weight;
                            ?>
                            <li><span>Sub Total</span> <span>Rp. {{$subtotal}}</span></li>
                        </ul>
                    </div>
                    <br>
                    @endforeach
                    <div class="breadcumb_area bg-img" style="background-image: url(assets/user/img/bg-img/breadcumb.jpg);">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-12">
                                    <div class="page-title text-center">
                                        <h2>Batas Waktu Bayar</h2>
                                        <h3><span id="days">00</span><span> Hari : </span><span id="hours">00</span><span> Jam : </span><span id="minutes">00</span><span> Menit : </span><span id="seconds">00</span><span> Detik</span></h3>
                                        <h3 id="countdown" style="font-style: bold; margin-bottom: 2%; color: red;"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading">
                            <h5>Pembayaran</h5>
                            <p>Detail</p>
                        </div>

                        <ul class="order-details-form mb-4">
                        	<li><span>Status</span><span>{{$transaction->status}}</span></li>
                            <li><span>Kota Tujuan</span> <span>{{$transaction->regency}}</span></li>
                            <li><span>Provinsi</span> <span>{{$transaction->province}}</span></li>
                            <li><span>Biaya Pengiriman</span> <span>Rp. {{$transaction->shipping_cost}}</span></li>
                            <li><span>Jumlah Item</span> <span>{{$qty}}</span></li>
                            <li><span>Berat Total</span> <span>{{$weight}} gram</span></li>
                            <li><span>Total</span> <span>Rp. {{$total+$transaction->shipping_cost}}</span></li>
                        </ul>
                        <label>Upload Bukti Pembayaran</label>
                        <br>
                        @if($transaction->status=='unverified')
                            <input type="file" name="prof_of_payment" class="form-control">
                            <br>
                            <button class="btn btn-success">Upload</button>
                        @else
                            <label style="margin-top: 20px; color: red;">Tidak Dapat Mengupload Bukti</label>
                        @endif
                    </div>
                </div>
               </div>
              </div>
             </div>
    <script>
        var countdown = function(end, elements, callback) {
        var _second = 1000,
            _minute = _second * 60,
            _hour   = _minute * 60,
            _day    = _hour * 24,

        end = new Date(end),
        timer,

      calculate = function() {

        var now = new Date(),
          remaining = end.getTime() - now.getTime(),
          data;

        if(isNaN(end)) {
          console.log('Invalid date/time');
          return;
        }

        if(remaining <= 0) {
          clearInterval(timer);

          if(typeof callback === 'function') {
            callback();
          }

        }else {
          if(!timer) {
            timer = setInterval(calculate, _second);
          }

          data = {
              'days': Math.floor(remaining / _day),
              'hours': Math.floor((remaining % _day) / _hour),
              'minutes': Math.floor((remaining % _hour) / _minute),
              'seconds': Math.floor((remaining % _minute) / _second)
          }
          if(elements.length) {
            for (x in elements) {
              var x = elements[x];
              data[x] = ('00' + data[x]).slice(-2);
              document.getElementById(x).innerHTML = data[x];
            }
          }
          
        }
      };
    calculate();
}   
</script>
<script>
    countdown('{{$transaction->timeout}}', ['days', 'hours', 'minutes', 'seconds'], function() {
        document.getElementById('countdown').innerHTML = "Pembayaran dibatalkan";
      });
</script>
@endsection
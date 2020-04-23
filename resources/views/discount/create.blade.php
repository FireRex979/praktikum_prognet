@extends('layouts.admin')
@section('judul','Admin | Tambah Diskon Page')
@section('content')
<div style="margin-top:50px ">
    <div class="container">
        <div class="row align-items-centre">
            <div class="col-lg-2">
            </div>
            <div class="col-md-8">
                <div class="component">
                    <div class="card">
                        <form class="form-signin" action="{{ route('discounts.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="card-header">
                            <center>
                                <span>Tambah Diskon</span>
                            </center>
                        </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Product</label>
                            <select name="id_product" class="form-control" aria-describedby="basic-addon1" aria-label="Produk>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"><?php echo $product->product_name." (".$product->category.")"; ?></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Besar Diskon</label>
                            <input type="text" class="form-control" placeholder="Besar Diskon" aria-label="Nama Produk" aria-describedby="basic-addon1" name="percentage">
                        </div>
                        <div class="form-group">
                            <label>Mulai</label>
                            <input type="date" class="form-control" aria-label="Mulai" aria-describedby="basic-addon1" name="start">
                        </div>
                        <div class="form-group">
                            <label>Berakhir</label>
                            <input type="date" class="form-control" aria-label="Berakhir" aria-describedby="basic-addon1" name="end">
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-md btn-outline-success" type="submit">Tambah</button>
                        </div>
                        </form>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
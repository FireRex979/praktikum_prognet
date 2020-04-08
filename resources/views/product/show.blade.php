@extends('layouts.table')
@section('judul','Admin | Produk Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Produk</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      @foreach($products as $product)
                      <tbody>
                        <tr>
                          <td>Nama Produk</td>
                          <td>{{ $product->product_name }}</td>
                        </tr>
                        <tr>
                          <td>Rating Produk</td>
                          <td>{{ $product->product_rate }}</td>
                        </tr>
                        <tr>
                          <td>Stock</td>
                          <td>{{ $product->stock }}</td>
                        </tr>
                        <tr>
                          <td>Berat</td>
                          <td>{{ $product->weight }}</td>
                        </tr>
                        <tr>
                          <td>Harga</td>
                          <td>{{ $product->price }}</td>
                        </tr>
                        <tr>
                          <td>Deskripsi</td>
                          <td>{{ $product->description }}</td>
                        </tr>
                        <tr>
                          <td>Kategori</td>
                          <td>{{ $product->category_name }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                    <span>
                    <button type="button" class="btn btn-warning btn-icon-text" onclick="/createProduct">
                          <i class="mdi mdi-file-restore btn-icon-prepend"></i>   
                          <a href="{{ route('products.edit',$product->id)}}" style="color: white;">Edit Produk</a>
                  </button>
                  <button type="button" class="btn btn-success btn-icon-text" onclick="/addImage/{{ $product->id }}">
                          <i class="mdi mdi-file-restore btn-icon-prepend"></i>     
                          <a href="/addImage/{{ $product->id }}" style="color: white;">Tambah Foto Produk</a>
                  </button>
                  @endforeach
                  </span>
                  </div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Foto Produk</h4>
                    <div class="container">
                      <div class="row">
                       @foreach($image as $images)
                        <div class="col-md-4">
                          <div class="thumbnail">
                            <img class="img-fluid-left img-thumbnail" src="/image/product_image/{{$images->image_name}}" alt="light">
                            <form method="post" action="{{ route('product_images.destroy', $images->id) }}">
                              @csrf
                              @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon-text">
                              Delete
                           </button>
                           </form>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>    
                </div>
              </div>
                
            </div>
            
@endsection

    
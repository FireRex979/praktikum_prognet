@extends('layouts.table')
@section('judul','Admin | Produk Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Produk</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td>Nama Produk</td>
                          <td>{{ $products->product_name }}</td>
                        </tr>
                        <tr>
                          <td>Rating Produk</td>
                          <td>{{ $products->product_rate }}</td>
                        </tr>
                        <tr>
                          <td>Stock</td>
                          <td>{{ $products->stock }}</td>
                        </tr>
                        <tr>
                          <td>Berat</td>
                          <td>{{ $products->weight }}</td>
                        </tr>
                        <tr>
                          <td>Harga</td>
                          <td>{{ $products->price }}</td>
                        </tr>
                        <tr>
                          <td>Deskripsi</td>
                          <td>{{ $products->description }}</td>
                        </tr>
                        <tr>
                          <td>Jenis Kategori</td>
                          <td>
                            {{ $products->category }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                    <span>
                    <button type="button" class="btn btn-warning btn-icon-text" onclick="/createProduct">    
                          <a href="{{ route('products.edit',$products->id)}}" style="color: white;"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i> </a>
                  </button>
                  <button type="button" class="btn btn-success btn-icon-text" onclick="/addImage/{{ $products->id }}">
                          <a href="/addImage/{{ $products->id }}" style="color: white;"><i class="mdi mdi-image-area btn-icon-prepend"></i>     </a>
                  </button>
                  </span>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title">Kategori Produk</h4>
                  <button class="btn btn-success"><a href="/category_detail/create/{{ $products->id }}" style="color: white;">Tambah Kategori</a></button>
                    <div class="container">
                      <div class="table">
                        <table class="table-striped">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Kategori</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($categories as $category)
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td> <a class="btn-sm btn-danger" href="/category_detail/delete/{{ $category->id }}" onclick="return confirm('Apa yakin ingin menghapus data ini?')">Delete</a> </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>    
                </div>
                </div>
                <div class="card">
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
                
            </div>
            
@endsection

    
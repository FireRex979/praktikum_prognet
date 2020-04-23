@extends('layouts.table')
@section('judul','Admin | Diskon Produk Page')
@section('content')
    <div class="col-lg-11 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Diskon Produk</h4>
                  <span>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-upload btn-icon-prepend"></i>     
                      <a href="{{ route('discounts.create') }}" style="color: white;">Tambah Diskon</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="">
                      <i class="mdi  mdi-delete btn-icon-prepend"></i>
                      <a href="/discounts-trash" style="color: white">Trash</a>
                  </button>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                          Nama Produk
                          </th>
                          <th>
                            Jenis Produk
                          </th>
                          <th>
                            Diskon
                          </th>
                          <th>
                            Mulai Berlaku
                          </th>
                          <th>
                            Akhir Berlaku
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($discounts as $discount)
                        <tr>
                          <td>{{ $discount->product_name }}</td>
                          <td>{{ $discount->category }}</td>
                          <td>{{ $discount->percentage }}</td>
                          <td>{{ $discount->start }}</td>
                          <td>{{ $discount->end }}</td>
                          <td>
                              <a class="btn-sm btn-warning" href="{{ route('discounts.edit',$discount->id)}}">Edit</a>
                              
                              <a class="btn-sm btn-danger" href="/discounts/delete/{{ $discount->id }}" onclick="return confirm('Apa yakin ingin menghapus data ini?')">Delete</a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $discounts->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
@extends('main.main')
@section('container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Penjualan</h1>
          </div><!-- /.col --> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Penjualan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <!-- /.info-box -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Penjualan</h3>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-lg-tambahMentor">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
    
                  <form action="/tambahPenjualan" method="post" enctype="multipart/form-data" id="quickForm">
                    @csrf
                    <div class="modal fade" id="modal-lg-tambahMentor">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Form Tambah Penjualan</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="container">
                                  <div class="row">
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group">
                                          <label>Barang</label>
                                          <select name="idBarang" class="custom-select rounded-1" id="exampleSelectRounded0" required>
                                            <option value="">--Pilih Barang--</option>
                                            @foreach ($dataBarangs as $dataBarang)
                                              <option value="{{ $dataBarang->id }}">{{ $dataBarang->nama }} | Stock : {{ $dataBarang->stok }} | Jenis : {{ $dataBarang->jenisBarang }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Jumlah Terjual</label>
                                            <input type="text" name="jumlahTerjual" class="form-control" placeholder="Masukkan Jumlah terjual" required>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control" placeholder="Masukkan tanggal" required>
                                        </div>
                                    </div>
                                  </div> 
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
              </div>
              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr style="text-align: center">
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Stok</th>
                      <th>Jumlah Terjual</th>
                      <th>Tanggal</th>
                      <th>Jenis Barang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($penjualans as $penjualan)
                   
                    <tr style="text-align: center">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $penjualan->nama }}</td>
                      <td>{{ $penjualan->stok }}</td>
                      <td>{{ $penjualan->jumlahTerjual }}</td>
                      <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                      <td>{{ $penjualan->jenisBarang }}</td>
                      <td>
                        <div style="text-align: center">
                          <button type="button" class="btn btn-primary" style="width: 50px" data-toggle="modal" data-target="#modal-lg-editBarang{{ $penjualan->id }}">
                              <i class="fas fa-pencil-alt" style="color: #fff"></i>
                          </button>
                          <form action="/hapusPenjualan/{{ $penjualan->id }}" method="post" class="d-inline" style="width: 48%">
                              @csrf
                              <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah kamu yakin?')" style="width: 50px">
                                  <i class="bi bi-trash-fill" style="color: #fff"></i>
                              </button>
                          </form>
                          <div style="clear: both;"></div>
                        </div>
                      
                      </td>
                    </tr>  

                    @endforeach
                  </tbody>
                </table>
              </div>


              @foreach($penjualans as $penjualan)
                <form action="/editPenjualan" method="post" enctype="multipart/form-data" id="editBarang">
                    @csrf
                    <input type="hidden" name="idPenjualan" value="{{ $penjualan->id }}">
                    <div class="modal fade" id="modal-lg-editBarang{{ $penjualan->id }}">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Edit Penjualan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                              <div class="container">
                                <div class="row">
                                  <div class="col-sm-6">
                                      
                                      <div class="form-group">
                                        <label>Barang</label>
                                        <select name="idBarang" class="custom-select rounded-1" id="exampleSelectRounded0" required>
                                          <option value="{{ $penjualan->idBarang }}">--Pilih Barang--</option>
                                          @foreach ($dataBarangs as $dataBarang)
                                            <option value="{{ $dataBarang->id }}">{{ $dataBarang->nama }} | Stock : {{ $dataBarang->stok }} | Jenis : {{ $dataBarang->jenisBarang }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Jumlah Terjual</label>
                                          <input type="text" value="{{ $penjualan->jumlahTerjual }}" name="jumlahTerjual" class="form-control" placeholder="Masukkan Jumlah terjual" required>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Tanggal</label>
                                          <input type="date" value="{{ $penjualan->tanggal }}"  name="tanggal" class="form-control" placeholder="Masukkan tanggal" required>
                                      </div>
                                  </div>
                                </div> 
                            </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </form>
              @endforeach


              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
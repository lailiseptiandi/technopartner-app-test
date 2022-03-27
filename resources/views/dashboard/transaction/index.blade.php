@extends('layouts.dashboard')
@section('title')
    <title>Transaction</title>
@endsection
@push('after-style')
    <style>
        textarea {
            min-height: 150px !important;
        }

    </style>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Saldo Saat Ini</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($saldo, '2', ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Pemasukan</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($pemasukan, '2', ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Pengeluaran</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($pengeluaran, '2', ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 mb-3">
                    <a href="" data-target="#add-data" data-toggle="modal" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Transaksi Bulan</h4>

                            </div>
                            <div class="card-body">
                                <div class="float-right mb-2">
                                    <form action="{{ route('fiter.date') }}" method="get">
                                        <div class="d-flex flex-row">
                                            <div class="mr-2">
                                                <input type="date" name="start_date" value="" class="form-control" id="">
                                            </div>
                                            <div class="mr-2">
                                                <input type="date" name="end_date" value="" class="form-control" id="">
                                            </div>
                                            <button type="submit" class="btn btn-primary">List</button>
                                        </div>
                                    </form>
                                </div>
                                <table class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2">No</th>
                                            <th scope="col" rowspan="2">Tanggal</th>
                                            <th scope="col" rowspan="2">Kategori</th>
                                            <th scope="col" rowspan="2">Deskripsi</th>
                                            <th scope="col" colspan="2">Jenis</th>
                                            <th scope="col" rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->Category->name }}</td>
                                                <td>{{ substr($transaction->description, 0, 20) }}...</td>
                                                @if ($transaction->Category->type_category == 'pemasukan')
                                                    <td>Rp {{ number_format($transaction->nominal, '2', ',', '.') }}</td>
                                                    <td>-</td>
                                                @elseif ($transaction->Category->type_category == 'pengeluaran')
                                                    <td>-</td>
                                                    <td>Rp {{ number_format($transaction->nominal, '2', ',', '.') }}</td>
                                                @endif

                                                <td>
                                                    <form action="{{ route('transaction.destroy', $transaction->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" data-target="#edit-data-{{ $transaction->id }}"
                                                            data-toggle="modal" class="btn btn-primary btn-sm">Edit</a>
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- modal untuk tambah data --}}
    <div class="modal fade" id="add-data" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Jenis Transaksi</label>
                            <select id="type_category" class="form-control">
                                <option value="">-- Pilih Jenis Transaksi --</option>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="category_id" id="sub_category" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror"
                                value="{{ old('nominal') }}">
                            @error('nominal')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                            <span class="font-italic text-danger float-right">* Drag Perbesar</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($transactions as $item)
        <div class="modal fade" id="edit-data-{{ $item->id }}" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('transaction.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Jenis Transaksi</label>
                                <select class="form-control">
                                    {{-- <option value="pemasukan">Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option> --}}
                                    @foreach ($categories as $c)
                                        @if ($item->category_id == $c->id)
                                            <option value="{{ $item->categori_id }}">{{ $c->type_category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $c)
                                        @if ($item->category_id == $c->id)
                                            <option value="{{ $item->categori_id }}">{{ $c->name }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" name="nominal"
                                    class="form-control @error('nominal') is-invalid @enderror"
                                    value="{{ $item->nominal }}">
                                @error('nominal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="5">{{ $item->description }}</textarea>
                                <span class="font-italic text-danger float-right">* Drag Perbesar</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('after-script')
    <script>
        // $(document).ready(function() {
        //     $('.js-example-basic-single').select2();
        // });

        $('#type_category').change(function() {
            var id = $(this).val();

            $('#sub_category').find('option').not(':first').remove();

            $.ajax({
                url: 'type_category/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    var len = 0;
                    if (response.data != null) {
                        len = response.data.length;
                    }

                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response.data[i].id;
                            var name = response.data[i].name;

                            var option = "<option value='" + id + "'>" + name + "</option>";

                            $("#sub_category").append(option);
                        }
                    }
                }
            })
        });
    </script>
@endpush

@extends('layouts.master')
@section('page_title', 'Data Transaksi')
@section('content')

    
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column bg-primary text-white">
                    <h6 class="card-title">Total Transaksi</h6>
                    <div class="row">
                        <div class="col">
                            <div class="data-section">
                                <p>{{ count($transactions) }}</p>
                                <p>{{ Sv::idr_format($total->totalNominalTransaksi) }}</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon">
                                <span class="fas fa-exchange-alt fa-4x"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column bg-danger text-white">
                    <h6 class="card-title">Total Transaksi Simpan</h6>
                    <div class="row">
                        <div class="col">
                            <div class="data-section">
                                <p>{{ $total->totalSimpan }}</p>
                                <p>{{ Sv::idr_format($total->totalNominalSimpan) }}</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon">
                                <span class="fas fa-money-bill-wave fa-4x"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column bg-success text-white">
                    <h6 class="card-title">Total Transaksi Ambil</h6>
                    <div class="row">
                        <div class="col">
                            <div class="data-section">
                                <p>{{ $total->totalAmbil }}</p>
                                <p>{{ Sv::idr_format($total->totalNominalAmbil) }}</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon">
                                <span class="fas fa-hand-holding-usd fa-4x"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Data Transaksi</h6>
            {!! Qs::getPanelOptions() !!}
        </div>
        
        <div class="card-body">
            <div class="filter-menu">
                {!! Form::open(['url' => route('savings.show', Qs::hash($student_id)), 'method' => 'get']) !!}
                  {!! Form::label('fromDate', 'Dari Tanggal:') !!}
                  {!! Form::date('fromDate', request('fromDate')) !!}
                  {!! Form::label('toDate', 'Hingga Tanggal:') !!}
                  {!! Form::date('toDate', request('toDate')) !!}
                  {!! Form::submit('Filter') !!}
                {!! Form::close() !!}
              </div>
            <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-classes">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>N/S</th>
                                <th>Nama</th>
                                <th>Waktu Transaksi</th>
                                <th>Jenis Transaksi</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->student->user->name}}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->transaction_type }}</td>
                                        <td>{{ $transaction->note ?? '-'}}</td>
                                        <td>{{ $transaction->amount }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Tidak ada data transaksi yang sesuai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    {{--Class List Ends--}}

@endsection

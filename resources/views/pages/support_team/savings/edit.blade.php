@extends('layouts.master')
@section('page_title', 'Transaksi')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Transaksi</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div class="text-center p-3 border rounded bg-light">
                        <h4 class="mb-4">Sisa Saldo</h4>
                        <h2 class="font-weight-bold">{{ Sv::idr_format($saving->balance) }}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="ajax-store" method="post" action="{{ route('savings.transaction', Qs::Hash($saving->student_id)) }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Nama <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input name="title" value="{{ $saving->student->user->name }}" required type="text" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="transaction_type" class="col-lg-3 col-form-label font-weight-semibold">Jenis Transaksi</label>
                            <div class="col-lg-6">
                                <select class="form-control select" name="transaction_type" id="transaction_type">
                                    <option selected value="Ambil">Ambil</option>
                                    <option value="Simpan">Simpan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-lg-3 col-form-label font-weight-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input class="form-control number-input" value="{{ old('amount') }}" required name="amount" id="amount" type="text">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-lg-3 col-form-label font-weight-semibold">Keterangan</label>
                            <div class="col-lg-6">
                                <input class="form-control" value="{{ old('note') }}" name="note" id="note" type="text">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Transaction Create Ends--}}

@endsection

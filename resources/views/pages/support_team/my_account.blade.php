@extends('layouts.master')
@section('page_title', 'Pengaturan Akun')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Pengaturan Akun</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#change-pass" class="nav-link active" data-toggle="tab">Ganti Password</a></li>
                @if(Qs::userIsPTA())
                    <li class="nav-item"><a href="#edit-profile" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Kelola Profil</a></li>
                @endif
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="change-pass">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="post" action="{{ route('my_account.change_pass') }}">
                                @csrf @method('put')

                                <div class="form-group row">
                                    <label for="current_password" class="col-lg-3 col-form-label font-weight-semibold">Password Sekarang <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input id="current_password" name="current_password"  required type="password" class="form-control" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-lg-3 col-form-label font-weight-semibold">Password Baru <span class="text-muted">(Min: 8 karakter Max: 120 karakter)</span><span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input id="password" name="password"  required type="password" class="form-control" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-lg-3 col-form-label font-weight-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input id="password_confirmation" name="password_confirmation"  required type="password" class="form-control" >
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-danger">Submit <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if(Qs::userIsPTA())
                    <div class="tab-pane fade" id="edit-profile">
                        <div class="row">
                            <div class="col-md-6">
                                <form enctype="multipart/form-data" method="post" action="{{ route('my_account.update') }}">
                                    @csrf @method('put')

                                    <div class="form-group row">
                                        <label for="name" class="col-lg-3 col-form-label font-weight-semibold">Nama</label>
                                        <div class="col-lg-9">
                                            <input disabled="disabled" id="name" class="form-control" type="text" value="{{ $my->name }}">
                                        </div>
                                    </div>

                                    @if($my->username)
                                        <div class="form-group row">
                                            <label for="username" class="col-lg-3 col-form-label font-weight-semibold">Username</label>
                                            <div class="col-lg-9">
                                                <input disabled="disabled" id="username" class="form-control" type="text" value="{{ $my->username }}">
                                            </div>
                                        </div>

                                    @else

                                        <div class="form-group row">
                                            <label for="username" class="col-lg-3 col-form-label font-weight-semibold">Username </label>
                                            <div class="col-lg-9">
                                                <input id="username" name="username"  type="text" class="form-control" >
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label for="email" class="col-lg-3 col-form-label font-weight-semibold">Email </label>
                                        <div class="col-lg-9">
                                            <input id="email" value="{{ $my->email }}" name="email"  type="email" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-lg-3 col-form-label font-weight-semibold">Phone </label>
                                        <div class="col-lg-9">
                                            <input id="phone" value="{{ $my->staff->phone }}" name="phone"  type="text" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address" class="col-lg-3 col-form-label font-weight-semibold">Alamat </label>
                                        <div class="col-lg-9">
                                            <input id="address" value="{{ $my->address }}" name="address"  type="text"  class="form-control" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="prov_id" class="col-lg-3 col-form-label font-weight-semibold">Provinsi: </label>
                                        <div class="col-lg-9">
                                            <select data-placeholder="Pilih..." onchange="getCity(this.value)"  name="prov_id"
                                                id="prov_id" class="select-search form-control">
                                                <option value=""></option>
                                                @foreach ($provinces as $prov)
                                                    <option {{ ($my->prov_id  == $prov->prov_id ? 'selected' : '') }} value="{{ $prov->prov_id }}">{{ $prov->prov_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="city_id" class="col-lg-3 col-form-label font-weight-semibold">Kabupaten / Kota: </label>
                                        <div class="col-lg-9">
                                            <select data-placeholder="Pilih..." onchange="getDistrict(this.value)"  name="city_id"
                                            id="city_id" class="select-search form-control">
                                            <option value=""></option>
                                            @foreach ($cities as $city)
                                                <option {{ ($my->city_id  == $city->city_id ? 'selected' : '') }} value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="dis_id" class="col-lg-3 col-form-label font-weight-semibold">Kecamatan: </label>
                                        <div class="col-lg-9">
                                            <select  data-placeholder="Pilih" onchange="getSubDistrict(this.value)"
                                            class="select-search form-control" name="dis_id" id="dis_id">
                                            <option value=""></option>
                                            @foreach ($districts as $dis)
                                                <option {{ ($my->dis_id  == $dis->dis_id ? 'selected' : '') }} value="{{ $dis->dis_id }}">{{ $dis->dis_name }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="subdis_id" class="col-lg-3 col-form-label font-weight-semibold">Kelurahan / Desa: </label>
                                        <div class="col-lg-9">
                                            <select  data-placeholder="Pilih" class="select-search form-control" name="subdis_id"
                                            id="subdis_id">
                                            <option value=""></option>
                                            @foreach ($subdistricts as $subdis)
                                            <option {{ ($my->subdis_id  == $subdis->subdis_id ? 'selected' : '') }} value="{{ $subdis->subdis_id }}">{{ $subdis->subdis_name }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address" class="col-lg-3 col-form-label font-weight-semibold">Ubah Foto</label>
                                        <div class="col-lg-9">
                                            <input  accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-danger">Submit form <i class="icon-paperplane ml-2"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    @if ($my->photo)
                                    <img src="{{ $my->photo }}" alt="Profile Photo" style="max-width: 200px; display: block; margin: 0 auto;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{--My Profile Ends--}}

@endsection

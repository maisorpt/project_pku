@extends('layouts.master')
@section('page_title', 'Edit User')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit User Details</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-update" action="{{ route('users.update', Qs::hash($user->id)) }}" data-fouc>
                @csrf @method('PUT')
                <h6>Data Personal</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="user_type"> Pilih Jenis User: <span class="text-danger">*</span></label>
                                <select disabled="disabled" class="form-control select" id="user_type">
                                    <option value="">{{ strtoupper($user->user_type) }}</option>
                                </select>
                            </div>
                        </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Lengkap: <span class="text-danger">*</span></label>
                            <input value="{{ $user->name }}" required type="text" name="name"
                                placeholder="Nama Lengkap" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Username: <span class="text-danger">*</span></label>
                            <input value="{{ $user->username }}" type="text" required name="username" class="form-control"
                                placeholder="Username">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin: <span class="text-danger">*</span></label>
                            <select class="select form-control" id="gender" name="gender" required data-fouc
                                data-placeholder="Pilih...">
                                <option value=""></option>
                                <option {{ $user->gender == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                                <option {{ $user->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tanggal Kerja:</label>
                                <input autocomplete="off" name="emp_date" value="{{ $user->staff[0]['emp_date'] }}" type="text" class="form-control date-pick" placeholder="Pilih tanggal">

                            </div>
                        </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tanggal Lahir:</label>
                            <input name="dob" value="{{ $user->dob }}" type="text" 
                                class="form-control date-pick" placeholder="Pilih tanggal">

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tempat Lahir:</label>
                            <input value="{{ $user->pob }}" type="text"  name="pob" class="form-control"
                                placeholder="Tempat Lahir">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Telepon:</label>
                            <input value="{{ $user->staff[0]['phone'] }}" type="text"  name="phone" class="form-control"
                                placeholder="Nomor Telepon">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="prov_id">Provinsi:</label>
                            <select data-placeholder="Pilih..." onchange="getCity(this.value)"  name="prov_id"
                                id="prov_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach ($provinces as $prov)
                                    <option {{ ($user->prov_id  == $prov->prov_id ? 'selected' : '') }} value="{{ $prov->prov_id }}">{{ $prov->prov_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city_id">Kabupaten / Kota:</label>
                            <select data-placeholder="Pilih..." onchange="getDistrict(this.value)"  name="city_id"
                                id="city_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach ($cities as $city)
                                <option {{ ($user->city_id  == $city->city_id ? 'selected' : '') }} value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="dis_id">Kecamatan:</label>
                        <select  data-placeholder="Pilih" onchange="getSubDistrict(this.value)"
                            class="select-search form-control" name="dis_id" id="dis_id">
                            <option value=""></option>
                            @foreach ($districts as $dis)
                            <option {{ ($user->dis_id  == $dis->dis_id ? 'selected' : '') }} value="{{ $dis->dis_id }}">{{ $dis->dis_name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="subdis_id">Kelurahan / Desa:</label>
                        <select  data-placeholder="Pilih" class="select-search form-control" name="subdis_id"
                            id="subdis_id">
                            <option value=""></option>
                            @foreach ($subdistricts as $subdis)
                            <option {{ ($user->subdis_id  == $subdis->subdis_id ? 'selected' : '') }} value="{{ $subdis->subdis_id }}">{{ $subdis->subdis_name }}</option>
                        @endforeach
                        </select>
                    </div>
         
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat:</label>
                            <input value="{{ $user->address }}" class="form-control" placeholder="Alamat" name="address"
                                type="text" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">Upload Foto:</label>
                            <input value="{{ $user->photo }}" accept="image/*" type="file" name="photo"
                                class="form-input-styled" data-fouc>
                            <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                        </div>
                    </div>
                </div>

            </fieldset>



            </form>
        </div>

    </div>
@endsection

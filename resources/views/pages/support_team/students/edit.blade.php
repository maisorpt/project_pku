@extends('layouts.master')
@section('page_title', 'Edit Informasi')
@section('content')

    <div class="card">
        <div class="card-header bg-white header-elements-inline">
            <h6 id="ajax-title" class="card-title">Form ubah data {{ $sr->user->name }}</h6>

            {!! Qs::getPanelOptions() !!}
        </div>

        <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-update"
            data-reload="#ajax-title" action="{{ route('students.update', Qs::hash($sr->id)) }}" data-fouc>
            @csrf @method('PUT')
            <h6>Data Pribadi</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap: <span class="text-danger">*</span><span class="text-muted">(Min: 6 huruf)</span></label>
                            <input value="{{ $sr->user->name }}" required type="text" name="name"
                                placeholder="Nama Lengkap" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Username: <span class="text-danger">*</span><span class="text-muted">(Min: 6 huruf)</span></label>
                            <input value="{{ $sr->user->username }}" type="text" required name="username"
                                class="form-control" placeholder="Username">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin: <span class="text-danger">*</span></label>
                            <select class="select form-control" id="gender" name="gender" required data-fouc
                                data-placeholder="Pilih...">
                                <option value=""></option>
                                <option {{ $sr->user->gender == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki
                                </option>
                                <option {{ $sr->user->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Lahir: <span class="text-danger">*</span></label>
                            <input name="dob" value="{{ $sr->user->dob }}" type="text" required
                                class="form-control date-pick" placeholder="Pilih tanggal...">

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tempat Lahir: <span class="text-danger">*</span></label>
                            <input value="{{ $sr->user->pob }}" type="text" required name="pob" class="form-control"
                                placeholder="Tempat Lahir">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat: <span class="text-danger">*</span><span class="text-muted">(Min: 6 huruf)</span></label>
                            <input value="{{ $sr->user->address }}" class="form-control" placeholder="Alamat" name="address"
                                type="text" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="prov_id">Provinsi: <span class="text-danger">*</span></label>
                            <select data-placeholder="Pilih..." onchange="getCity(this.value)" required name="prov_id"
                                id="prov_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach ($provinces as $prov)
                                    <option {{ $sr->user->prov_id == $prov->prov_id ? 'selected' : '' }}
                                        value="{{ $prov->prov_id }}">{{ $prov->prov_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city_id">Kabupaten / Kota: <span class="text-danger">*</span></label>
                            <select data-placeholder="Pilih..." onchange="getDistrict(this.value)" required name="city_id"
                                id="city_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach ($cities as $city)
                                    <option {{ $sr->user->city_id == $city->city_id ? 'selected' : '' }}
                                        value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="dis_id">Kecamatan: <span class="text-danger">*</span></label>
                        <select required data-placeholder="Pilih" onchange="getSubDistrict(this.value)"
                            class="select-search form-control" name="dis_id" id="dis_id">
                            <option value=""></option>
                            @foreach ($districts as $dis)
                                <option {{ $sr->user->dis_id == $dis->dis_id ? 'selected' : '' }}
                                    value="{{ $dis->dis_id }}">{{ $dis->dis_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="subdis_id">Kelurahan: <span class="text-danger">*</span></label>
                        <select required data-placeholder="Pilih" class="select-search form-control" name="subdis_id"
                            id="subdis_id">
                            <option value=""></option>
                            @foreach ($subdistricts as $subdis)
                                <option {{ $sr->user->subdis_id == $subdis->subdis_id ? 'selected' : '' }}
                                    value="{{ $subdis->subdis_id }}">{{ $subdis->subdis_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">Upload Foto:</label>
                            <input accept="image/*" type="file" name="photo"
                                class="form-input-styled" data-fouc>
                            <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                        </div>
                    </div>
                </div>

            </fieldset>

            <h6>Student Data</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="my_class_id">Mustawa: </label>
                            <select onchange="getClassSections(this.value)" name="my_class_id" required id="my_class_id"
                                class="form-control select-search" data-placeholder="Select Class">
                                <option value=""></option>
                                @foreach ($my_classes as $c)
                                    <option {{ $sr->my_class_id == $c->id ? 'selected' : '' }}
                                        value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="section_id">Kelas: </label>
                            <select name="section_id" required id="section_id" class="form-control select"
                                data-placeholder="Select Section">
                                <option value="{{ $sr->section_id }}">{{ $sr->section->name }}</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year_admitted">Tahun Masuk: </label>
                            <select name="year_admitted" data-placeholder="Choose..." id="year_admitted"
                                class="select-search form-control">
                                <option value=""></option>
                                @for ($y = date('Y', strtotime('- 10 years')); $y <= date('Y'); $y++)
                                    <option {{ $sr->year_admitted == $y ? 'selected' : '' }}
                                        value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="dorm_id">Asrama: </label>
                        <select data-placeholder="Choose..." name="dorm_id" id="dorm_id"
                            class="select-search form-control">
                            <option value=""></option>
                            @foreach ($dorms as $d)
                                <option {{ $sr->dorm_id == $d->id ? 'selected' : '' }} value="{{ $d->id }}">
                                    {{ $d->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kamar:</label>
                            <input type="text" name="dorm_room_no" placeholder="Kamar" class="form-control"
                                value="{{ $sr->dorm_room_no }}">
                        </div>
                    </div>
                </div>
            </fieldset>

            <h6>Data Wali Santri</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Ayah: <span class="text-muted">(Cth: Cahyadi)</span></label>
                            <input value="{{ $sr->parent->father_name }}" type="text" name="father_name"
                                placeholder="Nama Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Ibu: </label>
                            <input value="{{ $sr->parent->mother_name }}" type="text" name="mother_name"
                                placeholder="Nama Ibu" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Profesi Ayah:</label>
                            <input value="{{ $sr->parent->father_job }}" type="text" name="father_job"
                                placeholder="Profesi Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Telepon Ayah:</label>
                            <input value="{{ $sr->parent->father_phone }}" type="text" name="father_phone"
                                placeholder="Nomor Telepon Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Profesi Ibu:</label>
                            <input value="{{ $sr->parent->mother_job }}" type="text" name="mother_job"
                                placeholder="Profesi Ibu" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Telepon Ibu:</label>
                            <input value="{{ $sr->parent->mother_phone }}" type="text" name="mother_phone"
                                placeholder="Nomor Telepon Ibu" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_salary">Pemasukan Ayah: </label>
                            <select data-placeholder="Pilih" name="father_salary" id="father_salary"
                                class="select-search form-control">
                                <option value=""></option>
                                @foreach ($salary_types as $st)
                                    <option {{ $sr->parent->father_salary == $st->id ? 'selected' : '' }}
                                        value="{{ $st->id }}">{{ $st->salary_amount }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mother_salary">Pemasukan Ibu: </label>
                            <select data-placeholder="Pilih" name="mother_salary" id="mother_salary"
                                class="select-search form-control">
                                <option value=""></option>
                                @foreach ($salary_types as $st)
                                    <option {{ $sr->parent->mother_salary == $st->id ? 'selected' : '' }}
                                        value="{{ $st->id }}">{{ $st->salary_amount }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

        </form>
    </div>
@endsection

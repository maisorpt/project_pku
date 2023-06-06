@extends('layouts.master')
@section('page_title', 'Registrasi')
@section('content')
    <div class="card">
        <div class="card-header bg-white header-elements-inline">
            <h6 class="card-title">Silakan isi formulir di bawah ini untuk menambah data santri baru</h6>

            {!! Qs::getPanelOptions() !!}
        </div>

        <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation"
            action="{{ route('students.store') }}" data-fouc>
            @csrf
            <h6>Data Pribadi</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap: <span class="text-danger">*</span></label>
                            <input value="{{ old('name') }}" required type="text" name="name"
                                placeholder="Nama Lengkap" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Username: <span class="text-danger">*</span></label>
                            <input value="{{ old('username') }}" type="text" required name="username" class="form-control"
                                placeholder="Username">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin: <span class="text-danger">*</span></label>
                            <select class="select form-control" id="gender" name="gender" required data-fouc
                                data-placeholder="Pilih...">
                                <option value=""></option>
                                <option {{ old('gender') == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                                <option {{ old('gender') == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Lahir: <span class="text-danger">*</span></label>
                            <input name="dob" value="{{ old('dob') }}" type="text" required
                                class="form-control date-pick" placeholder="Pilih tanggal...">

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tempat Lahir: <span class="text-danger">*</span></label>
                            <input value="{{ old('pob') }}" type="text" required name="pob" class="form-control"
                                placeholder="Tempat Lahir">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat: <span class="text-danger">*</span></label>
                            <input value="{{ old('address') }}" class="form-control" placeholder="Alamat" name="address"
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
                                    <option value="{{ $prov->prov_id }}">{{ $prov->prov_name }}</option>
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
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="dis_id">Kecamatan: <span class="text-danger">*</span></label>
                        <select required data-placeholder="Pilih" onchange="getSubDistrict(this.value)"
                            class="select-search form-control" name="dis_id" id="dis_id">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="subdis_id">Kelurahan: <span class="text-danger">*</span></label>
                        <select required data-placeholder="Pilih" class="select-search form-control" name="subdis_id"
                            id="subdis_id">
                            <option value="">Pilih Kecamatan terlebih dahulu</option>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">Upload Foto:</label>
                            <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo"
                                class="form-input-styled" data-fouc>
                            <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                        </div>
                    </div>
                </div>

            </fieldset>

            <h6>Data Santri</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="my_class_id">Mustawa: <span class="text-danger">*</span></label>
                            <select onchange="getClassSections(this.value)" data-placeholder="Pilih" required
                                name="my_class_id" id="my_class_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach ($my_classes as $c)
                                    <option {{ old('my_class_id') == $c->id ? 'selected' : '' }}
                                        value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="section_id">Kelas: <span class="text-danger">*</span></label>
                            <select data-placeholder="Pilih Mustawa dulu" required name="section_id" id="section_id"
                                class="select-search form-control">
                                <option {{ old('section_id') ? 'selected' : '' }} value="{{ old('section_id') }}">
                                    {{ old('section_id') ? 'Selected' : '' }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year_admitted">Tahun Masuk: <span class="text-danger">*</span></label>
                            <select data-placeholder="Pilih" required name="year_admitted" id="year_admitted"
                                class="select-search form-control">
                                <option value=""></option>
                                @for ($y = date('Y', strtotime('- 10 years')); $y <= date('Y'); $y++)
                                    <option {{ old('year_admitted') == $y ? 'selected' : '' }}
                                        value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="dorm_id">Asrama: </label>
                        <select data-placeholder="Pilih" name="dorm_id" id="dorm_id"
                            class="select-search form-control">
                            <option value=""></option>
                            @foreach ($dorms as $d)
                                <option {{ old('dorm_id') == $d->id ? 'selected' : '' }} value="{{ $d->id }}">
                                    {{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kamar:</label>
                            <input type="text" name="dorm_room_no" placeholder="Nomor Kamar"
                                class="form-control" value="{{ old('dorm_room_no') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Pendaftaran:</label>
                            <input type="text" name="adm_no" placeholder="Nomor Pendaftaran" class="form-control"
                                value="{{ old('adm_no') }}">
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
                            <input value="{{ old('father_name') }}" type="text" name="father_name"
                                placeholder="Nama Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Ibu: </label>
                            <input value="{{ old('mother_name') }}" type="text" name="mother_name"
                                placeholder="Nama Ibu" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Profesi Ayah:</label>
                            <input value="{{ old('father_job') }}" type="text" name="father_job"
                                placeholder="Profesi Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Telepon Ayah:</label>
                            <input value="{{ old('father_phone') }}" type="text" name="father_phone"
                                placeholder="Nomor Telepon Ayah" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Profesi Ibu:</label>
                            <input value="{{ old('mother_job') }}" type="text" name="mother_job"
                                placeholder="Profesi Ibu" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Telepon Ibu:</label>
                            <input value="{{ old('mother_phone') }}" type="text" name="mother_phone"
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
                                    <option value="{{ $st->id }}">{{ $st->salary_amount }}</option>
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
                                    <option value="{{ $st->id }}">{{ $st->salary_amount }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

@extends('layouts.master')
@section('page_title', 'Manage Users')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Manage Users</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#new-user" class="nav-link active" data-toggle="tab">Buat User Baru</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Kelola User</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($user_types as $ut)
                            <a href="#ut-{{ Qs::hash($ut->id) }}" class="dropdown-item" data-toggle="tab">{{ $ut->name }}s</a>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="new-user">
                    <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-store" action="{{ route('users.store') }}" data-fouc>
                        @csrf
                    <h6>Data Personal</h6>
                        <fieldset>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="user_type"> Pilih Jenis User: <span class="text-danger">*</span></label>
                                            <select required data-placeholder="Pilih Jenis User" class="form-control select" name="user_type" id="user_type">
                                    @foreach($user_types as $ut)
                                        <option value="{{ Qs::hash($ut->id) }}">{{ $ut->name }}</option>
                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nama Lengkap: <span class="text-danger">*</span><span class="text-muted">(Min: 6 karakter)</span></label>
                                        <input value="{{ old('name') }}" required type="text" name="name"
                                            placeholder="Nama Lengkap" class="form-control">
                                    </div>
                                </div>
            
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Username: <span class="text-danger">*</span><span class="text-muted">(Min: 6 karakter Max: 50 karakter)</span></label>
                                        <input value="{{ old('username') }}" type="text" required name="username" class="form-control"
                                            placeholder="Username">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="password">Password: <span class="text-muted">(Min: 6 karakter Max: 50 karakter)</span></label>
                                        <input id="password" type="password" name="password" class="form-control"  placeholder="Password">
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
                                            <option {{ old('gender') == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                                            <option {{ old('gender') == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Tanggal Kerja:</label>
                                            <input autocomplete="off" name="emp_date" value="{{ old('emp_date') }}" type="text" class="form-control date-pick" placeholder="Pilih tanggal">
    
                                        </div>
                                    </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tanggal Lahir: <span class="text-danger">*</span></label>
                                        <input name="dob" value="{{ old('dob') }}" type="text" required
                                            class="form-control date-pick" placeholder="Pilih tanggal">
            
                                    </div>
                                </div>
            
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tempat Lahir: <span class="text-danger">*</span>(Min: 6 karakter Max: 120 karakter)</label>
                                        <input value="{{ old('pob') }}" type="text" required name="pob" class="form-control"
                                            placeholder="Tempat Lahir">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nomor Telepon: <span class="text-danger">*</span><span class="text-muted">(Min: 6 karakter Max: 20 karakter)</span></label>
                                        <input value="{{ old('phone') }}" type="text" required name="phone" class="form-control"
                                            placeholder="Nomor Telepon">
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
                                        <label>Alamat: <span class="text-muted">(Min: 6 karakter Max: 120 karakter)</span><span class="text-danger">*</span></label>
                                        <input value="{{ old('address') }}" class="form-control" placeholder="Alamat" name="address"
                                            type="text" required>
                                    </div>
                                </div>
            
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

                    </form>
                </div>

                @foreach($user_types as $ut)
                    <div class="tab-pane fade" id="ut-{{Qs::hash($ut->id)}}">                         <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>N/S</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users->where('user_type', $ut->title) as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $u->photo }}" alt="photo"></td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->phone }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-left">
                                                    {{--Lihat Profil--}}
                                                    <a href="{{ route('users.show', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-eye"></i> Lihat Profil</a>
                                                    {{--Edit--}}
                                                    <a href="{{ route('users.edit', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                @if(Qs::userIsSuperAdmin())

                                                        <a href="{{ route('users.reset_pass', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-lock"></i> Reset password</a>
                                                        {{--Delete--}}
                                                        <a id="{{ Qs::hash($u->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Hapus</a>
                                                        <form method="post" id="item-delete-{{ Qs::hash($u->id) }}" action="{{ route('users.destroy', Qs::hash($u->id)) }}" class="hidden">@csrf @method('delete')</form>
                                                @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{--Student List Ends--}}

@endsection

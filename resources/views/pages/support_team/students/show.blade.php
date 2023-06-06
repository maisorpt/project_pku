@extends('layouts.master')
@section('page_title', 'Student Profile - ' . $sr->user->name)
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" id="show_student">Data Santri</a>
                        </li>
                        <li>
                            <a href="#" class="nav-link" id="show_parent">Data Orang tua</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- Basic Info --}}
                        <div class="tab-pane fade show active" id="basic-info">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Nama</td>
                                        <td>{{ $sr->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">ADM_NO</td>
                                        <td>{{ $sr->adm_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Kelas</td>
                                        <td>{{ $sr->my_class->name . ' ' . $sr->section->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tahun Masuk</td>
                                        <td>{{ $sr->year_admitted }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Jenis Kelamin</td>
                                        <td>{{ $sr->user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">TTL</td>
                                        <td>{{ $sr->user->pob }}, {{ strftime('%e %B %Y', strtotime($sr->user->dob)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Alamat</td>
                                        <td>{{ $sr->user->address }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Provinsi-Kota/Kabupaten-Kecamatan-Kelurahan</td>
                                        <td>
                                            @if ($sr->user->prov_id)
                                                {{ $sr->user->province->prov_name }}/
                                            @endif
                                            @if ($sr->user->city_id)
                                                {{ $sr->user->city->city_name }}/
                                            @endif
                                            @if ($sr->user->dis_id)
                                                {{ $sr->user->district->dis_name }}/
                                            @endif
                                            @if ($sr->user->subdis_id)
                                                {{ $sr->user->subdistrict->subdis_name }}
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($sr->dorm_id)
                                        <tr>
                                            <td class="font-weight-bold">Asrama</td>
                                            <td>{{ $sr->dorm->name . ' ' . $sr->dorm_room_no }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show" id="parent-info">
                            <table class="table table-bordered">
                                <thead>
                                    <th colspan="2" class="font-weight-bold">
                                       <h3>Data Ayah</h3>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Nama</td>
                                        <td>{{ $sr->parent->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Nomor Telepon</td>
                                        <td>{{ $sr->parent->father_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pekerjaan</td>
                                        <td>{{ $sr->parent->father_job }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Penghasilan</td>
                                        <td>{{ $sr->parent->father_salary }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <th colspan="2" class="font-weight-bold">
                                       <h3>Data Ibu</h3>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Nama</td>
                                        <td>{{ $sr->parent->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Nomor Telepon</td>
                                        <td>{{ $sr->parent->mother_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pekerjaan</td>
                                        <td>{{ $sr->parent->mother_job }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Penghasilan</td>
                                        <td>{{ $sr->parent->mother_salary }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card">
                <div class="card-body">
                    <img style="width: 90%; height:90%" src="{{ $sr->user->photo }}" alt="photo" class="rounded-circle">
                    <br>
                    <h3 class="mt-3">{{ $sr->user->name }}</h3>
                </div>
            </div>
        </div>
    </div>


    {{-- Student Profile Ends --}}

@endsection

@extends('layouts.master')
@section('page_title', 'User Profile - '.$user->name)
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" >Data Personal</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{--Basic Info--}}
                        <div class="tab-pane fade show active" id="basic-info">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Nama</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Name</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">ADM_NO</td>
                                        <td>
                                            @if($user->staff[0]['code'])
                                            {{ $user->staff[0]['code']}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Jenis Kelamin</td>
                                        <td>{{ $user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">TTL</td>
                                        <td>
                                            @if($user->pob)
                                            {{ $user->pob }},
                                            @endif
                                            @if($user->dob)
                                            {{ strftime('%e %B %Y', strtotime($user->dob)) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Alamat</td>
                                        <td>
                                            @if($user->address)
                                            {{ $user->address }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Provinsi-Kota/Kabupaten-Kecamatan-Kelurahan</td>
                                        <td>
                                            @if ($user->prov_id)
                                                {{ $user->province->prov_name }}/
                                            @endif
                                            @if ($user->city_id)
                                                {{ $user->city->city_name }}/
                                            @endif
                                            @if ($user->dis_id)
                                                {{ $user->district->dis_name }}/
                                            @endif
                                            @if ($user->subdis_id)
                                                {{ $user->subdistrict->subdis_name }}
                                            @endif
                                        </td>
                                    </tr>
                                @if($user->user_type == 'parent')
                                    <tr>
                                        <td class="font-weight-bold">Children/Ward</td>
                                        <td>
                                        @foreach(Qs::findMyChildren($user->id) as $sr)
                                            <span> - <a href="{{ route('students.show', Qs::hash($sr->id)) }}">{{ $sr->user->name.' - '.$sr->my_class->name. ' '.$sr->section->name }}</a></span><br>

                                            @endforeach
                                        </td>
                                    </tr>
                                @endif

                                @if($user->user_type == 'teacher')
                                    <tr>
                                        <td class="font-weight-bold">My Subjects</td>
                                        <td>
                                            @foreach(Qs::findTeacherSubjects($user->id) as $sub)
                                                <span> - {{ $sub->name.' ('.$sub->my_class->name.')' }}</span><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif

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
                    <img style="width: 90%; height:90%" src="{{ $user->photo }}" alt="photo" class="rounded-circle">
                    <br>
                    <h3 class="mt-3">{{ $user->name }}</h3>
                </div>
            </div>
        </div>
    </div>


    {{--User Profile Ends--}}

@endsection

@extends('layouts.master')
@section('page_title', 'Data Tabungan')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Data Tabungan</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#all-classes" class="nav-link active" data-toggle="tab">Data Tabungan</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Kelas</a>
                    <div class="dropdown-menu dropdown-menu-right">

                        @foreach ($classes as $c)
                            @foreach ($sections as $s)
                                @if ($c->id == $s->my_class_id)
                                    <a href="#s{{ $c->id }}-{{$s->id}}" class="dropdown-item"
                                        data-toggle="tab">{{ $c->name . ' ' . $s->name }}</a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-classes">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>N/S Santri</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Saldo Tabungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($savings as $saving)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $saving->student_id }}</td>
                                    <td>{{ $saving->student->user->name }}</td>
                                    <td>{{ $saving->student->my_class->name }} {{ $saving->student->section->name }}</td>
                                    <td>{!! Sv::idr_format($saving->balance) !!},00</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ route('savings.show', Qs::hash($saving->student_id)) }}" class="dropdown-item"><i class="icon-eye"></i> Lihat Detail</a>
                                                    @if(Qs::userIsTeamSA())
                                                        <a href="{{ route('savings.edit', Qs::hash($saving->student_id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Transaksi</a>
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
                @foreach ($classes as $c)
                    @foreach ($sections as $s)
                        @if ($c->id == $s->my_class_id)
                            <div class="tab-pane fade" id="s{{ $c->id }}-{{$s->id}}">
                                <table class="table datatable-button-html5-columns">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>N/S Santri</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Saldo Tabungan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($savings as $saving)
                                            @foreach ($saving->student()->where('my_class_id', $c->id)->where('section_id', $s->id)->get() as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $saving->student_id }}</td>
                                                    <td>{{ $student->user->name }}</td>
                                                    <td>{{ $student->my_class->name }} {{ $student->section->name }}</td>
                                                    <td>{{ Sv::idr_format($saving->balance) }},00</td>
                                                    <td class="text-center">
                                                        <div class="list-icons">
                                                            <div class="dropdown">
                                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                    <i class="icon-menu9"></i>
                                                                </a>
                
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a href="{{ route('savings.show', Qs::hash($saving->student_id)) }}" class="dropdown-item"><i class="icon-eye"></i> Lihat Detail</a>
                                                                    @if(Qs::userIsTeamSA())
                                                                        <a href="{{ route('savings.edit', Qs::hash($saving->student_id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                                        <a href="{{ route('st.reset_pass', Qs::hash($saving->student_id)) }}" class="dropdown-item"><i class="icon-lock"></i> Reset password</a>
                                                                    @endif
                
                                                                    {{--Delete--}}
                                                                    @if(Qs::userIsSuperAdmin())
                                                                        <a id="{{ Qs::hash($saving->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Hapus</a>
                                                                        <form method="post" id="item-delete-{{ Qs::hash($saving->student_id) }}" action="{{ route('students.destroy', Qs::hash($saving->student_id)) }}" class="hidden">@csrf @method('delete')</form>
                                                                    @endif
                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        @endif
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>

    {{-- Class List Ends --}}

@endsection

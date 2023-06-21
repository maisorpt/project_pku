@extends('layouts.master')
@section('page_title', 'Dashboard')
@section('content')

    @if(Qs::userIsTeamSA())
    
       <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex flex-column bg-primary text-white">
                        <div class="row">
                            <div class="col">
                                <div class="data-section">
                                    <h3 class="mb-0">{{ $users->where('user_type', 'student')->count() }}</h3>
                                    <span class="text-uppercase font-size-xs font-weight-bold">Jumlah Santri</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon">
                                    <span class="icon-users4 icon-3x opacity-75"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex flex-column bg-danger text-white">
                        <div class="row">
                            <div class="col">
                                <div class="data-section">
                                    <h3 class="mb-0">{{ $users->where('user_type', 'teacher')->count() }}</h3>
                                    <span class="text-uppercase font-size-xs">Jumlah Pengajar</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon">
                                    <span class="icon-users2 icon-3x opacity-75"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex flex-column bg-success text-white">
                        <div class="row">
                            <div class="col">
                                <div class="data-section">
                                    <h3 class="mb-0">{{ $users->where('user_type', 'admin')->count() }}</h3>
                                    <span class="text-uppercase font-size-xs">Jumlah Admin</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon">
                                    <span class="icon-users4 icon-3x opacity-75"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       @endif

    {{--Events Calendar Begins--}}
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">School Events Calendar</h5>
         {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="fullcalendar-basic"></div>
        </div>
    </div>
    {{--Events Calendar Ends--}}
    @endsection

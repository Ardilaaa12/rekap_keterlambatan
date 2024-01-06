@extends('layouts.template')

@section('content')
    {{-- @php
      $count = DB::table('student')->count();
    @endphp --}}
    <div class="jumbotron py-4 px-5">
        @if (Session::get('failed'))
            <div class="alert alert-danger mt-3"> {{ Session::get('failed') }}</div>
        @endif
        <h1 class="mt-3">Dashboard</h1>
        <div class="tags">
            <h5 style="color: black;">
                <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/index">Home</a> /
                <a class="button_waterpump" style="color: black;" href="#">Dashboard</a>
            </h5>    
        </div>
        <hr class="my-4">
        <div class="content-card d-flex">
            <div class="card m-2" style="width: 50%;">
                <div class="card-body">
                    <h4 class="card-title">Peserta Didik Rayon {{ $name_rayon }}</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <h4 style="margin: -35px 0 0 80px;">{{ $student }}</h4>
                </div>
            </div>
            <div class="card m-2" style="width: 50%;">
                <div class="card-body">
                    <h4 class="card-title">Keterlambatan {{ $name_rayon }} Hari Ini</h4>
                    <h6><?php echo strftime(" %d %B %Y"); ?></h6>
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <h4 style="margin: -35px 0 0 80px;">{{$todayLateCount}}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

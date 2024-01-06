@extends('layouts.template')

@section('content')
    <a href="{{ route('late.berkas') }}" class="btn btn-primary float-sm-end m-2">Kembali</a>
    <h1>Detail Data Keterlambatan</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/index">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('late.berkas')}}">Data Keterlambatan</a> /
            <a class="button_waterpump" style="color: black;" href="#">Detail Data Keterlambatan</a>
        </h5>    
    </div>
    <br>
    <h5>{{ $student['name']}} | {{ $student['nis'] }} | {{ $student->rayon['rayon'] }} | {{ $student->rombel['rombel'] }}</h5>
    @php $no = 1; @endphp
    <div class="row row-cols-1 row-cols-md-3 justify-content-start">
        @php $no = 1; @endphp
        @foreach ($lates as $item)
            <div class="col">
                <div class="card m-2" style="width: 20rem;">
                    <img src="{{ asset('storage/' . $item['bukti']) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Keterlambatan Ke-{{ $no++ }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item['date_time_late'] }}</h6>
                        <p class="card-text">{{ $item['information'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

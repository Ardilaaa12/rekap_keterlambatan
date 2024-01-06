@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <h1 class="mt-3">Data Keterlambatan</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/index">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Keterlambatan</a>
        </h5>    
    </div>
    <div class="tab">
        <div class="p-4">
            <a href="{{ route('late.excel-export')}}" class="btn btn-info float-sm-end mb-2">Export Data Keterlambatan</a>
        </div>
        <br>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Keseluruhan Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('late.berkas')}}">Rekapitulasi Data</a>
            </li>
        </ul>
        <form class="d-flex w-25 float-end m-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <table class="table table-hoverd mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Informasi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($lates as $item)
                    <tr>
                        {{-- name, type, price, stock disamakan dengan yang ada di migrations --}}
                        {{-- <td>{{ $no++ }}</td> --}}
                        <td>{{ $no++ }}</td>
                        <td>
                            {{ $item['student']['nis'] }}
                            <br>
                            {{ $item['student']['name'] }}
                        </td>
                        <td>{{ $item['date_time_late'] }}</td>
                        <td>{{ $item['information'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="d-flex justify-content-end">
        pagination
        @if ($users->count())
        {{$users->links()}}  
        @endif
    </div> --}}
@endsection

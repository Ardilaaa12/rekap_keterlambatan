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
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Keterlambatan</a>
        </h5>    
    </div>
    <div class="tab">
        <div class="p-4">
            <a href="{{ route('late.export-excel')}}" class="btn btn-info float-sm-end m-2">Export Data Keterlambatan</a>
            <a href="{{ route('late.create') }}" class="btn btn-primary float-sm-end m-2">Tambah</a>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Keseluruhan Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('late.file')}}">Rekapitulasi Data</a>
            </li>
        </ul>
        <a href="{{ route('late.index') }}" class="btn btn-outline-dark float-sm-end m-2">Clear</a>
        <form class="d-flex w-25 float-end m-2" method="GET" action="{{ route('late.cari')}}">
            <input class="form-control me-2" name="search" id="search" placeholder="Search">
        </form>
        <table class="table table-hoverd mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Informasi</th>
                    {{-- <th>Bukti</th> --}}
                    <th>Aksi</th>
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
                        {{-- <td><img src="{{ asset('storage/' . $item['bukti'])}}" alt=""></td> --}}
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('late.edit', $item['id']) }}" class="btn btn-primary me-2 ">Edit</a>
                            <form action="{{ route('late.delete', $item['id']) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
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

@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Data Keterlambatan</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Keterlambatan</a>
        </h5>    
    </div>    <div class="tab">
        <div class="p-4">
            <a href="{{ route('late.export-excel')}}" class="btn btn-info float-sm-end m-2">Export Data Keterlambatan</a>
            <a href="{{ route('late.create') }}" class="btn btn-primary float-sm-end m-2">Tambah</a>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('late.index')}}">Keseluruhan Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Rekapitulasi Data</a>
            </li>
        </ul>
        <form class="d-flex w-25 float-end m-2" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jumlah Keterlambatan</th>
                    <th>Detail</th>
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
                        <td>{{ $item['student']['nis'] }}</td>
                        <td>{{ $item['student']['name'] }}</td>
                        <td>{{ DB::table('lates')->where('student_id', $item['student_id'])->count()  }}</td>
                        <td><a href="{{ route('late.detail', ['id' => $item->student_id]) }}">lihat</a></td>
                        {{-- <td class="d-flex justify-content-center"><a href="{{ route('late.print', $item['id'])}}" class="btn btn-primary float-sm-end m-2">Cetak Surat Pernyataan</a></td> --}}
                        @if(DB::table('lates')->where('student_id', $item['student_id'])->count()>= 3)
                        <td class="d-flex">
                            <a href="{{ route('late.print', ['id' => $item->student_id]) }}" class="btn btn-danger">Cetak Surat Pernyataan</a>
                        </td>
                        @endif
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

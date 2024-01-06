@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <h1 class="mt-3">Data Rayon</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Rayon</a>
        </h5>
    </div>
    <div class="tab">
        <div class="p-4">
            <a href="{{ route('rayon.create') }}" class="btn btn-primary float-sm-start mb-3">Tambah Pengguna</a>
        </div>
        <a href="{{ route('rayon.index') }}" class="btn btn-outline-dark float-sm-end m-2">Clear</a>
        <form class="d-flex w-25 float-end m-2" method="GET" action="{{ route('rayon.cari') }}">
            <input class="form-control me-2" name="search" id="search" placeholder="Search">
        </form>
        <table class="table table-hoverd mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Rayon</th>
                    <th>Pembimbing Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($rayons as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['rayon'] }}</td>
                        <td>{{ $item['user']['name'] }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('rayon.edit', $item['id']) }}" class="btn btn-primary me-2 ">Edit</a>
                            <form action="{{ route('rayon.delete', $item['id']) }}" method="post">
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
@endsection

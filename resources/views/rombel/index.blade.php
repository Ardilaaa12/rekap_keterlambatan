@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <h1 class="mt-3">Data Rombel</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Rombel</a>
        </h5>    
    </div>
    <div class="tab">
        <div class="p-4">
            <a href="{{ route('rombel.create') }}" class="btn btn-primary float-sm-start m-2">Tambah</a>
        </div>
        <a href="{{ route('rombel.index') }}" class="btn btn-outline-dark float-sm-end m-2">Clear</a>
        <form class="d-flex w-25 float-end m-2" method="GET" action="{{ route('rombel.cari')}}">
            <input class="form-control me-2" name="search" id="search" placeholder="Search">
        </form>
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rombel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($rombels as $item)
                    <tr>
                        {{-- name, type, price, stock disamakan dengan yang ada di migrations --}}
                        {{-- <td>{{ $no++ }}</td> --}}
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['rombel'] }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('rombel.edit', $item['id']) }}" class="btn btn-primary me-2 ">Edit</a>
                            <form action="{{ route('rombel.delete', $item['id']) }}" method="post">
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

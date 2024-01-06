@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <h1 class="mt-3">Data Siswa</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/index">Home</a> /
            <a class="button_waterpump" style="color: black;" href="#">Data Siswa</a>
        </h5>    
    </div>
    <div class="tab">
        <a href="{{ route('student.data') }}" class="btn btn-outline-success float-sm-end m-2">Clear</a>
        <form class="d-flex w-25 float-end m-2" method="GET" action="{{ route('student.search')}}">
            <input class="form-control me-2" name="search" id="search" placeholder="Search">
        </form>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($students as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['nis'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['rombel']['rombel']}}</td>
                        <td>{{ $item['rayon']['rayon']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Tambah Data Siswa</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('student.index')}}">Data Siswa</a> /
            <a class="button_waterpump" style="color: black;" href="#">Tambah Data Siswa</a>
        </h5>    
    </div>
    <form action="{{ route('student.store')}}" class="card mt-3 p-5" method="POST">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @csrf
        <div class="mb-3 row">
            <label for="nis" class="form-label">NIS</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" value="{{ old('nis') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rombel" class="form-label">Rombel</label>
            <div class="col-sm-10">
                <select name="rombel" id="rombel" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rombel as $item)              
                        <option value="{{ $item['rombel']}}">{{ $item['rombel']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rayon" class="form-label">Rayon</label>
            <div class="col-sm-10">
                <select name="rayon" id="rayon" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rayon as $item)              
                        <option value="{{ $item['rayon']}}">{{ $item['rayon']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form>
@endsection

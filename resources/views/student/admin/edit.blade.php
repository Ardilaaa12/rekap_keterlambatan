@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Edit Data Siswa</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('student.index')}}">Data Siswa</a> /
            <a class="button_waterpump" style="color: black;" href="#">Edit Data Siswa</a>
        </h5>    
    </div>
    <form action="{{ route('student.update', $student['id'])}}" class="card mt-3 p-5" method="POST">
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
        @method('PATCH')
        <div class="mb-3 row">
            <label for="nis" class="form-label">NIS</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" value="{{ $student['nis'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $student['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rombel_id" class="form-label">Rombel</label>
            <div class="col-sm-10">
                <select name="rombel_id" id="rombel_id" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rombels as $item)
                    <option value="{{ $item['id'] }}" {{ $item['id'] == $student['rombel_id'] ? 'selected' : '' }}> {{ $item['rombel'] }} </option>                   
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rayon_id" class="form-label">Rayon</label>
            <div class="col-sm-10">
                <select name="rayon_id" id="rayon_id" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rayons as $item)
                        <option value="{{ $item['id'] }}" {{ $item['id'] == $student['rayon_id'] ? 'selected' : '' }}> {{ $item['rayon'] }} </option>                   
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form>
@endsection

@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Edit Data Rayon</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('rayon.index')}}">Data Rayon</a> /
            <a class="button_waterpump" style="color: black;" href="#">Edit Data Rayon</a>
        </h5>    
    </div>
    <form action="{{ route('rayon.update', $rayon['id']) }}" class="card mt-3 p-5" method="POST">
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
            <label for="rayon" class="form-label">Rayon</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rayon" name="rayon" value="{{ $rayon['rayon'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="form-label">Pembimbing Siswa</label>
            <div class="col-sm-10">
                <select name="name" id="name" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rayons as $item)
                        <option value="{{ $item['id'] }}" {{ $item['id'] == $rayon['user_id'] ? 'selected' : '' }}> {{ $item['name'] }} </option>                   
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form>
@endsection

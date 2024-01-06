@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Tambah Data Keterlambatan</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('late.index')}}">Data Keterlambatan</a> /
            <a class="button_waterpump" style="color: black;" href="#">Tambah Data Keterlambatan</a>
        </h5>    
    </div>
    <form action="{{ route('late.store') }}" class="card mt-3 p-5" method="POST" enctype="multipart/form-data">
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
            <label for="name" class="form-label">Nama</label>
            <div class="col-sm-10">
                <select name="name" id="name" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($lates as $item)              
                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="date_time_late" class="form-label">Tanggal</label>
            <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}">
        </div>
        <div class="mb-3">
            <label for="information" class="form-label">Keterangan Keterlambatan</label>
            <textarea class="form-control" id="information" name="information" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="bukti" class="form-label">Bukti</label>
            <input class="form-control" type="file" id="bukti" name="bukti">
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form>
@endsection

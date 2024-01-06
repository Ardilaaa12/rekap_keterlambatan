@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Edit Data Keterlambatan</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('late.index')}}">Data Keterlambatan</a> /
            <a class="button_waterpump" style="color: black;" href="#">Edit Data Keterlambatan</a>
        </h5>    
    </div>
    <br>
    <div class="tab">

        <form action="{{ route('late.update', $late['id']) }}" class="card mt-3 p-5" method="POST" enctype="multipart/form-data">
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
                <label for="student_id" class="form-label">Nama</label>
                <div class="col-sm-10">
                    <select name="student_id" id="student_id" class="form-control">
                        <option selected hidden disabled>Pilih</option>
                        @foreach ($lates as $item) 
                            <option value="{{ $item['id'] }}" {{ $item['id'] == $late['student_id'] ? 'selected' : '' }}> {{ $item['name'] }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="date_time_late" class="form-label">Tanggal</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late" value="{{ $late['date_time_late'] }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="information" class="form-label">Keterangan Keterlambatan</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="information" name="information" rows="3" value="{{ $late['information'] }}">{{ $late['information'] }}</textarea>
                </div>
            </div>
            <div class="mb-3">
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="bukti" name="bukti">
                    <input type="hidden" class="form-control" id="buktiOld" name="buktiOld" value="{{ $late['bukti'] }}">
                    <img src="{{ asset('storage/' . $late['bukti']) }}" class="card-img-top m-3 w-25" alt="...">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
        </form>
    </div>
    {{-- <form action="{{ route('late.update', $late['id']) }}" class="card mt-3 p-5" method="POST">
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
            <label for="name" class="form-label">Nama</label>
            <div class="col-sm-10">
                <select name="name" id="name" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($lates as $item) 
                        <option value="{{ $item['id'] }}" {{ $item['id'] == $late['student_id'] ? 'selected' : '' }}> {{ $item['student']['name'] }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="date_time_late" class="form-label">Tanggal</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late" value="{{ $late['date_time_late'] }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="information" class="form-label">Keterangan Keterlambatan</label>
            <textarea class="form-control" id="information" name="information" rows="3" value="{{ $late['bukti'] }}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form> --}}
@endsection

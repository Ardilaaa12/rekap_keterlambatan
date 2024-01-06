@extends('layouts.template')

@section('content')
    <h1 class="mt-3">Edit Data Rombel</h1>
    <div class="tags">
        <h5 style="color: black;">
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="/dashboard">Home</a> /
            <a class="button_waterpump" style="color: rgb(101, 100, 100);" href="{{ route('rombel.index')}}">Data Rombel</a> /
            <a class="button_waterpump" style="color: black;" href="#">Edit Data Rombel</a>
        </h5>    
    </div>
    <form action="{{ route('rombel.update', $rombel['id']) }}" class="card mt-3 p-5" method="POST">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div> 
        @endif
        {{-- token syarat kirim data (agar sistem membaca bahwa data ini berasal dari sumber yang sah) --}}
        @csrf
        {{-- menimpa nilai dr attr method di form, agar saka kaya yang ada di routenya--}}
        @method('PATCH')
        <div class="mb-3 row">
            <label for="rombel" class="form-label">Rombel</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rombel" name="rombel" value="{{ $rombel['rombel'] }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </form>
@endsection
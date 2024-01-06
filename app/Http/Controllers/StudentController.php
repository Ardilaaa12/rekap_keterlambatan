<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\rombel;
use App\Models\rayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('rombel', 'rayon')->get();
        return view('student.admin.index', compact('students'));
    }

    public function data()
    {
        $rayon = Rayon::where('user_id', Auth::user()->id)->pluck('id');
        $students = Student::where('rayon_id', $rayon)->get();

        return view('student.ps.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombel = Rombel::with('student')->get();
        $rayon = Rayon::with('student')->get();
        // $students = Student::with('rombel', 'rayon')->get();
        return view("student.admin.create", compact('rombel', 'rayon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);
    
        $rayon = Rayon::where('rayon', $request->rayon)->first();
        $rombel = Rombel::where('rombel', $request->rombel)->first();

        Student::create([
            'nis'=> $request->nis,
            'name'=> $request->name,
            'rombel_id'=> $rombel->id,
            'rayon_id' => $rayon->id,
        ]);
    
        return redirect()->route('student.index')->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::find($id);
        $rombels = Rombel::with('student')->get();
        $rayons = Rayon::with('student')->get();
        return view('student.admin.edit', compact('student', 'rombels', 'rayons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
            'rombel_id' => 'required',
            'rayon_id' => 'required',
        ]);
        
        Student::where('id', $id)->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
        ]);

        return redirect()->route('student.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }

    public function cari(Request $request)
    {
        //menangkap data pencarian
        $cari = $request->search;
        $students = Student::where('name', 'like', "%" . $cari . "%")->orWhere('nis', 'like', '%' . $cari . '%')->get();
        return view('student.admin.index', compact('students'));
    }

    public function search(Request $request)
    {
        $cari = $request->search;
        $students = Student::where('name', 'like', "%" . $cari . "%")->orWhere('nis', 'like', '%' . $cari . '%')->get();
        return view('student.ps.index', compact('students'));
    }
}

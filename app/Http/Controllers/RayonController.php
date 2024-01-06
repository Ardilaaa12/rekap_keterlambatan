<?php

namespace App\Http\Controllers;

use App\Models\rayon;
use App\Models\user;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rayons = Rayon::with('user')->get();
        return view('rayon.index', compact('rayons'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $rayons = User::where('role', 'ps')->get();
        return view("rayon.create", compact('rayons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rayon' => 'required',
            'name' => 'required',
        ]);
    
        $user = User::where('name', $request->name)->first();
        // dd($user);

        Rayon::create([
            'rayon' => $request->rayon,
            'user_id' => $user->id,
        ]);
    
        return redirect()->route('rayon.index')->with('success', 'Berhasil menambah data!');

    }

    /**
     * Display the specified resource.
     */
    public function show(rayon $rayon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rayon = Rayon::find($id);
        $rayons = User::where('role','ps')->get();
        return view('rayon.edit', compact('rayon', 'rayons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rayon' => 'required',
            'name' => 'required',
        ]);
        
        Rayon::where('id', $id)->update([
            'rayon' => $request->rayon,
            'user_id' => $request->name,
        ]);

        return redirect()->route('rayon.index')->with('success', 'Berhasil mengubah data!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Rayon::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }

    public function cari(Request $request)
    {
        //menangkap data pencarian
        $cari = $request->search;
        $rayons = Rayon::where('rayon', 'like', "%" . $cari . "%")->get();
        return view('rayon.index', compact('rayons'));
    }
}

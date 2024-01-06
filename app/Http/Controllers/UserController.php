<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rayon;
use App\Models\Late;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)) {
            if (Auth::user()->role == "admin") {
                return redirect('/dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }else {
            return redirect()->back()->with('failed', 'Email atau Password tidak sesuai. Silahkan coba lagi!');
        }
    }

    public function info()
    {
        return view('index');
    }

    public function dashboard()
    {
        $name_rayon = Rayon::where('user_id', Auth::user()->id)->pluck('rayon')->first();

        $rayons = Rayon::where('user_id', Auth::user()->id)->pluck('id');
        $students = Student::whereIn('rayon_id', $rayons)->pluck('id');
        $lates = Late::whereIn('student_id', $students)
            ->whereDate('date_time_late', Carbon::today())
            ->get();
        $todayLateCount = $lates->count();
        
        $student = Student::whereIn('rayon_id', $rayons)->count();

        return view('dashboard', compact('todayLateCount', 'student', 'name_rayon'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make(substr($request->name, 0, 3). substr($request->email, 0, 3))
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if ($request->password == "") {
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }else {
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        }
        return redirect()->route('user.index')->with('success', 'Berhasil mengubah data!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }

    public function cari(Request $request)
    {
        //menangkap data pencarian
        $cari = $request->search;
        $users = User::where('name', 'like', "%" . $cari . "%")->orWhere('email', 'like', '%' . $cari . '%')->orWhere('role', 'like', '%' . $cari . '%')->get();
        return view('user.index', compact('users'));
    }
}

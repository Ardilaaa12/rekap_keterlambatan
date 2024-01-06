<?php

namespace App\Http\Controllers;

use App\Models\late;
use App\Models\student;
use App\Models\rombel;
use App\Models\rayon;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;
use Excel;
use App\Exports\LateExport;
use App\Exports\LatesExport;

class LateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lates = Late::with('student')->get();
        return view('late.admin.index', compact('lates'));
    }

    public function file()
    {
        $lates = Late::select('student_id')->distinct()->get();
        return view('late.admin.card', compact('lates'));

    }

    public function detail(Request $request, $student_id)
    {
        $lates = Late::where('student_id', $student_id)->get();
    
        $student = Student::with('rayon', 'rombel')->find($student_id);
    
        return view('late.admin.detail', compact('lates', 'student'));
    }
    
    


    public function data()
    {        
        $rayon = Rayon::where('user_id', Auth::user()->id)->pluck('id')->first();
        $student = Student::where('rayon_id', $rayon)->pluck('id');

        $lates = Late::whereIn('student_id', $student)->get();

        return view("late.ps.index", compact('lates'));
    }

    public function berkas()
    {
        $rayon = Rayon::where('user_id', Auth::user()->id)->pluck('id');
        $students = Student::where('rayon_id', $rayon)->pluck('id');

        $lates = Late::selectRaw('lates.student_id as student_id, students.name as student_name, students.nis, COUNT(*) as total_late, MAX(lates.date_time_late) as lates_late_date')
            ->join('students', 'lates.student_id', '=', 'students.id')
            ->groupBy('student_id', 'students.name', 'students.nis')
            ->whereIn('student_id', $students)
            ->get();

        $student = Late::with('student')->simplePaginate(5);

        return view('late.ps.card', compact('lates','student'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $student_id)
    {
        $lates = Late::where('student_id', $student_id)->get();
        $student = Student::with('rayon', 'rombel')->find($student_id);
        return view('late.ps.detail', compact('lates', 'student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lates = Student::with('late')->get();
        return view("late.admin.create", compact('lates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date_time_late' => 'required',
            'information' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $student = Student::where('name', $request->name)->first();

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti', $fileName, 'public');

            Late::create([
                'date_time_late' => $request->date_time_late,
                'information' => $request->information,
                'bukti' => $filePath, // Simpan path atau nama file ke dalam database
                'student_id' => $student->id,
            ]);

            return redirect()->route('late.index')->with('success', 'Berhasil menambah data!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $late = Late::find($id);
        $lates = Student::with('late')->get();
        return view('late.admin.edit', compact('late', 'lates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required',
            'date_time_late' => 'required',
            'information' => 'required',
        ]);
 
        if ($request->bukti == "") {
            Late::where('id', $id)->update([
                'student_id' => $request->student_id,
                'date_time_late' => $request->date_time_late,
                'information' => $request->information,
            ]);
        } else {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti', $fileName, 'public');

            if ($request->buktiOld) {
                Storage::delete($request->buktiOld);
            }

            Late::where('id', $id)->update([
                'date_time_late' => $request->date_time_late,
                'information' => $request->information,
                'bukti' => $filePath, // Simpan path atau nama file ke dalam database
                'student_id' => $request->student_id,
            ]);        
        }

        return redirect()->route('late.index')->with('success', 'Berhasil mengganti data!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $late = Late::find($id);
        if ($late->bukti) {
            Storage::delete($late->bukti);
        }
        Late::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }

    public function print($id) 
    {
        $late = Late::find($id);
        $student = Student::where('id', $id)->first();
        $rayon = Rayon::where('id', $student['rayon_id'])->first();
        $rombel = Rombel::where('id', $student['rombel_id'])->first();
        $ps = User::where('id', $rayon['user_id'])->first();
        return view("late.admin.print", compact('late', 'student', 'rayon', 'rombel', 'ps'));
    }

    public function downloadPDF($id)
    {
        $student = Student::where('id', $id)->first()->toArray();
        view()->share('student',$student);

        $rayon = Rayon::where('id', $student['rayon_id'])->first()->toArray();
        view()->share('rayon',$rayon);
        
        $rombel = Rombel::where('id', $student['rombel_id'])->first()->toArray();
        view()->share('rombel',$rombel);

        $ps = User::where('id', $rayon['user_id'])->first()->toArray();
        view()->share('ps',$ps);

        $pdf = PDF::loadview('late.admin.download', $student);
        return $pdf->download('Surat Pernyataan.pdf');
    }

    public function exportExcel()
    {
        $file_name = 'data_keterlambatan_siswa'.'.xlsx';
        return Excel::download(new LateExport, $file_name);
    }

    public function excelExport()
    {
        $file_name = 'data_keterlambatan_siswa'.'.xlsx';
        return Excel::download(new LatesExport, $file_name);
    }

    public function cetak($id) 
    {
        $late = Late::find($id);
        $student = Student::where('id', $id)->first();
        $rayon = Rayon::where('id', $student['rayon_id'])->first();
        $rombel = Rombel::where('id', $student['rombel_id'])->first();
        $ps = User::where('id', $rayon['user_id'])->first();
        return view("late.ps.print", compact('late', 'student', 'rayon', 'rombel', 'ps'));
    }

    public function unduhPDF($id)
    {
        $student = Student::where('id', $id)->first()->toArray();
        view()->share('student',$student);

        $rayon = Rayon::where('id', $student['rayon_id'])->first()->toArray();
        view()->share('rayon',$rayon);
        
        $rombel = Rombel::where('id', $student['rombel_id'])->first()->toArray();
        view()->share('rombel',$rombel);

        $ps = User::where('id', $rayon['user_id'])->first()->toArray();
        view()->share('ps',$ps);

        $pdf = PDF::loadview('late.admin.download', $student);
        return $pdf->download('Surat Pernyataan.pdf');
    }
    public function cari(Request $request)
    {
        //menangkap data pencarian
        $cari = $request->search;
        $lates = Late::where('information', 'like', "%" . $cari . "%")->orWhere('student_id', 'like', '%' . $cari . '%')->get();
        return view('late.admin.index', compact('lates'));
    }
}

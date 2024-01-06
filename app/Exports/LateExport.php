<?php

namespace App\Exports;

use App\Models\Late;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class LateExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Late::select('student_id', DB::raw('count(*) as total'))
            ->groupBy('student_id')
            ->with(['student' => function ($query) {
                $query->with('rombel', 'rayon');
            }])
        ->get();
    }

        // headings = nama nama th dari file excel
        public function headings(): array
        {
            return [
                "NIS", "Nama", "Rombel", "Rayon", "Total Keterlambatan"
            ];
        }
    
        // map : data yg akan dimunculkan di excelnya (sama kaya foreach di blade)
        public function map($late): array
        {
            $student = $late->student;

            return [
                $student->nis,
                $student->name,
                $student->rombel->rombel,
                $student->rayon->rayon,
                $late->total,
            ];
        }
}

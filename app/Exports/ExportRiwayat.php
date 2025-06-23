<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportRiwayat implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $sort = $this->request->input('sort', 'asc');
        $pub = $this->request->input('pub');
        $proses = $this->request->input('proses');
        $startDate = $this->request->input('tanggal_mulai');
        $endDate = $this->request->input('tanggal_selesai');
        $status = $this->request->input('status');

        $promosi = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->when($proses, fn($q) => $q->where('proses_permohonan.status', $proses))
            ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
            ->when($status, fn($q) => $q->where('proses_permohonan.status', $status))
            ->select('promosi.id_proses_permohonan as id', 'promosi.tanggal', 'promosi.judul as nama', 'promosi.nama_pemohon', 'proses_permohonan.status', 'unit.nama_unit as unit', 'sub_unit.nama_sub_unit as subUnit', 'promosi.tautan_promosi as tautan')
            ->get()
            ->map(fn($item) => [
                $item->id,
                $item->tanggal,
                'Promosi',
                $item->nama,
                $item->unit,
                $item->subUnit,
                $item->status,
                is_array(json_decode($item->tautan, true))
                    ? implode(', ', json_decode($item->tautan, true))
                    : $item->tautan,
            ]);

        $liputan = DB::table('liputan')
            ->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->when($proses, fn($q) => $q->where('proses_permohonan.status', $proses))
            ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
            ->when($status, fn($q) => $q->where('proses_permohonan.status', $status))
            ->select('liputan.id_proses_permohonan as id', 'liputan.tanggal', 'liputan.judul as nama', 'liputan.nama_pemohon', 'proses_permohonan.status', 'unit.nama_unit as unit', 'sub_unit.nama_sub_unit as subUnit', 'liputan.tautan_liputan as tautan')
            ->get()
            ->map(fn($item) => [
                $item->id,
                $item->tanggal,
                'Liputan',
                $item->nama,
                $item->unit,
                $item->subUnit,
                $item->status,
                is_array(json_decode($item->tautan, true))
                    ? implode(', ', json_decode($item->tautan, true))
                    : $item->tautan,
            ]);

        $data = match ($pub) {
            'promosi' => $promosi,
            'liputan' => $liputan,
            default => $promosi->merge($liputan),
        };

        $sorted = $sort === 'asc'
            ? $data->sortBy(fn($item) => $item[1]) // index 1 = tanggal
            : $data->sortByDesc(fn($item) => $item[1]);

        return new Collection($sorted->values());
    }

    public function headings(): array
    {
        return ['Kode Publikasi', 'Tanggal', 'Jenis', 'Nama Publikasi', 'Unit', 'Sub Unit', 'Status', 'Tautan'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header baris ke-1 tebal
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,    // ID
            'B' => 15,   // Tanggal
            'C' => 12,   // Jenis
            'D' => 40,   // Nama
            'E' => 20,   // Unit
            'F' => 25,   // Sub Unit
            'G' => 12,   // Status
            'H' => 40,   // Tautan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                // Buat semua cell ada border dan wrap text
                $cellRange = 'A1:' . $highestCol . $highestRow;
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Tambahkan header rata tengah horizontal
                $headerRange = 'A1:' . $highestCol . '1';
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );
            },
        ];
    }
}

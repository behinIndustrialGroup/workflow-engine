<?php

namespace Behin\SimpleWorkflowReport\Controllers\Scripts;

use Behin\SimpleWorkflowReport\Models\PettyCash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PettyCashExport implements FromCollection, WithHeadings, WithStyles
{
    protected $from;
    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = PettyCash::query();
        if ($this->from) {
            $query->whereDate('paid_at', '>=', $this->from);
        }
        if ($this->to) {
            $query->whereDate('paid_at', '<=', $this->to);
        }
        return $query->select('title','amount','paid_at','from_account')->get()->map(function($item){
            return [
                $item->title,
                $item->amount,
                $item->paid_at->format('Y-m-d'),
                $item->from_account,
            ];
        });
    }

    public function headings(): array
    {
        return ['عنوان خرج', 'مبلغ', 'تاریخ پرداخت', 'از حساب'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setRightToLeft(true);
        return [1 => ['font' => ['bold' => true]]];
    }
}


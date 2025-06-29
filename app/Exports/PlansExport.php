<?php

namespace App\Exports;

use App\Models\Plan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlansExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ids;
    protected $rowNumber = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return Plan::whereIn('id', $this->ids)->get([
            'name',
            'price',
            'highlight',
            'duration',
            'description',
            'is_active'
        ]);
    }
    
    public function headings(): array
    {
        return ['No', 'Name', 'Price', 'Highlight', 'Duration', 'Description', 'Status'];
    }

    public function map($plan): array
    {
        return [
            ++$this->rowNumber,
            $plan->name,
            $plan->price,
            $plan->highlight,
            $plan->duration,
            $plan->description,
            $plan->is_active ? 'Aktif' : 'Nonaktif',
        ];
    }
}

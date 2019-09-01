<?php

namespace App\Exports;

use App\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Orders::all();
    }

    public function headings(): array
    {
        return [
            'order_id',
            'order_datetime',
            'total_order_value', 
            'average_unit_price',
            'distinct_unit_count', 
            'total_units_count',
            'customer_state'
        ];
    }
}

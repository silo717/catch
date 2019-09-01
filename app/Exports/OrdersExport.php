<?php

namespace App\Exports;

use App\Orders;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Traits\DateManipulation;

class OrdersExport implements FromQuery, WithMapping, WithHeadings
{
    use DateManipulation;

    public function query()
    {
        return Orders::query();
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

    public function map($order): array
    {
        return [
            $order->order_id,
            $this->convertDate($order->order_datetime,'iso8601'),
            $order->total_order_value,
            $order->average_unit_price,
            $order->distinct_unit_count,
            $order->total_units_count,
            $order->customer_state
        ];
    }
}

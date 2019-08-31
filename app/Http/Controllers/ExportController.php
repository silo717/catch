<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{

    public function getJsonLines() {
        $jsonLines = file_get_contents('https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl');
        $saparator = "\n";
    
        if (empty($jsonLines)) {
            return json_encode([]);
        }
        $lines = [];
        $jsonLines = explode($saparator, trim($jsonLines));
        foreach ($jsonLines as $line) {
            $lines[] = $this->guardedJsonLine($line);
        }
        return $lines;
    }

    protected function guardedJsonLine($line)
    {
        if (is_string($line)) {
            $guardedJsonLine = json_decode((string) $line, true);
            return $guardedJsonLine;
        }
    }

    public function store($orders) {

       foreach($orders as $order) {
            $order_id = $order['order_id'];
            $order_date = $order['order_date'];
            $items = $order['items'];

            $sum_price = 0;
            $total_items = 0;
            foreach($items as $item) {
                $quantity = $item['quantity'];
                $unit_price = $item['unit_price'];
                $total_price = $unit_price*$quantity;
                $sum_price += $total_price;
                $total_items +=1;
            }
            $avg_unit_price =  $sum_price/$total_items;
            $total_units_count = $total_items;
            $discounts = $order['discounts'];
    
            $state = $order['customer']['shipping_address']['state'];

       }
       
    }

    public function run() {
       return $this->store($this->getJsonLines());
    }

}

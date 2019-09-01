<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\Traits\DateManipulation;

class SummaryController extends Controller
{
    use DateManipulation;

    public function summaryData($orders) {

        foreach($orders as $order) {
 
             $sum_price = 0; $total_units_count = 0; $product_list = []; $count_unique = 0;
 
             if(!empty($order['items'])) {  // empty order or 0 records order item value then will be excluded
                 foreach($order['items'] as $item) {
                     $quantity = $item['quantity'];
                     $unit_price = $item['unit_price'];
                     $total_price = $unit_price*$quantity;
                     $sum_price += $total_price;
                     $total_units_count += 1;
 
                     /* Check Unique Units (Actually got confuse here, so in this case I find a unit with the quantity is 1) */
                     if($quantity==1) {
                         $count_unique += $quantity;
                     }
 
                     array_push($product_list,$item['product']['product_id']);
                 }
             
                 $average_unit_price =  $sum_price/$total_units_count;
                 $customer_state = $order['customer']['shipping_address']['state'];
 
            
                 /*  Send to Store */
                 $parameter = [
                     'order_id' => $order['order_id'],
                     'order_datetime' =>  $this->convertDate($order['order_date'],'dbdate'),
                     'total_order_value' => $this->getTotalOrderValue($order['discounts'], $sum_price),
                     'average_unit_price' => $average_unit_price,
                     'distinct_unit_count' => $count_unique,
                     'total_units_count' => $total_units_count,
                     'customer_state' => $customer_state,
                     'product_list' => serialize($product_list)
                 ];
 
                 $this->Store($parameter);
                 
             }
        }
        
     }
 
     public function getTotalOrderValue(array $discounts, $sum_price) {
 
         $total_order_value = $sum_price; //without discount
 
         if(!empty($discounts)) { // with discount
             $total_order_value = $this->getOrderDiscounts($discounts, $sum_price);
         }
 
         return $total_order_value;
     }
 
     public function getOrderDiscounts(array $discounts, $sum_price) {
 
         foreach($discounts as $discount) {
             if($discount['priority']==1) {
                 if($discount['type']=="DOLLAR") {
                     $total_order_discount = $sum_price - $discount['value'];
                 } 
                 else {
                     $total_order_discount = $sum_price - ($sum_price * ($discount['value']/100));
                 }
             }
         }
 
         return $total_order_discount;
     }

    public function store(array $parameter) {
        return Orders::insert($parameter);
    }

    public function cleanData() {
        return Orders::truncate();
    }
}

<?php 

namespace App\Traits;
use DateTime;

trait DateManipulation
{
    public function convertDate($input_date, $convert_to)
    {
        $date = new DateTime($input_date);
        if($convert_to=='dbdate') {
            $result = $date->format('Y-m-d H:i:s');
        }
        else if($convert_to=='iso8601') {
            $result = $date->format('c');
        }
        return $result;
    }

}
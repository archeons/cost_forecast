<?php

include('../../config.php');
include 'Validator.php';

$result = [];
$error  = [];

class Cost extends Validator {
    protected $validator;
    
    function __construct() {
        $this->validator = new Validator();
    }
    
    public function validate($data) { 
        $this->validator->validate($data);
        return $this->validator->getErrors();
    } 
    
    public function calculate($data) {
        /*
         * How to calculate the cost:
            - RAM is one of the costlier components. We only need to have enough RAM for one day
            of study. 1000 studies require 500 MB RAM. The cost of 1GB of RAM per hour is
            0.00553 USD
         */
        $return = [];
        for($i = 0; $i < $data['month']; $i++) {
            $myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+$i month" ) );
            $date = date_create($myDate);
            $totalDays = cal_days_in_month(CAL_GREGORIAN, date_format($date,"m"), date_format($date,"Y"));
            $cost = ($data['nos']*0.00553*$totalDays*24)/2000;
            $nos = $data['nos'];
            if($i >= 1) {
                /*
                 *  Other costs are considered to be negligible compared to the above and are not considered in
                    this exercise. We do not consider the increase of cost within a month, for example, with a
                    current number of study of 1000 and a growth of 3%, the new number of study is 1030 at the
                    end of the month and the cost for that full month will be calculated with 1030 studies.
                 */
                for($j = 1; $j <= $i; $j++) {
                    $cost = $cost * 1.03;
                    $nos = ceil($nos * 1.03); // assumption we ceil up no of studies
                }
            }
            $return[$i]['date'] = date_format($date,"M Y");
            $return[$i]['nos'] = number_format($nos);
            /*
             *  Studies are kept indefinitely. 1 study use 10 MB of storage. 1 GB of storage cost 0.10 USD per month.
             */
            $cost = $cost + ($nos*10*0.1)/1000;
            $return[$i]['cost'] = '$'.number_format($cost,2);
        }       
        return $return;
    }
}

$cost = new Cost();
$error = $cost->validate($_POST);
if(!empty($error)) {
    $result = ['status' => 0, 'error' => $error];
    echo json_encode($result);
} else {
    $return = $cost->calculate($_POST);
    $result = ['status' => 1, 'error' => '', 'data' => $return];
    echo json_encode($result);
}

?>


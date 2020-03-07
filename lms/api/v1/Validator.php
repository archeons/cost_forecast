<?php

class Validator {
    protected $token;
    protected $nos;
    protected $growth;
    protected $month;
    protected $errors;
    
    function __construct() {
        $this->token = '';
        $this->nos = 0;
        $this->growth = 0;
        $this->month = 0;
        $this->errors = [];
    }
    
    public function validate($data) {
        if (!isset($data['token']) || $data['token'] != md5(APP_SECRET)) {
            $this->errors['token'] = ['Access Denied. Invalid Token.'];
        }
        if (!isset($data['nos']) || empty($data['nos'])) {
            $this->errors['nos'] = ['Please input a number greater than 0.'];
        } else {
            if(!is_numeric($data['nos'])) {
                $this->errors['nos'] = ['Please input a valid number.'];
            }
        }
        if (!isset($data['growth']) || empty($data['growth'])) {
            $this->errors['growth'] = ['Please input a number greater than 0.'];
        } else {
            if(!is_numeric($data['growth'])) {
                $this->errors['growth'] = ['Please input a valid number.'];
            }
        }
        if (!isset($data['month']) || empty($data['month'])) {
            $this->errors['month'] = ['Please input a number greater than 0.'];
        } else {
            if(!is_numeric($data['month'])) {
                $this->errors['month'] = ['Please input a valid number.'];
            }
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}


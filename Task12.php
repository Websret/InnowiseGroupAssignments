<?php
namespace src;

class MyCalculator{
    private $num1, $num2, $answer;

    public function __construct($num1, $num2){
        $this->num1 = $num1;
        $this->num2 = $num2;
    }

    public function __toString(){
        return $this->answer;
    }

    public function add(){
        $this->answer = $this->num1 + $this->num2;
        return $this;
    }

    public function multiply(){
         $this->answer = $this->num1 * $this->num2;
         return $this;
    }

    public function divide(){
        $this->answer = $this->num1 / $this->num2;
        return $this;
    }

    public function subtract(){
        $this->answer = $this->num1 - $this->num2;
        return $this;
    }

    public function divideBy($number){
        return $this->answer / $number;
    }

    public function addBy($number){
        return $this->answer + $number;
    }

    public function multiplyBy($number){
        return $this->answer * $number;
    }

    public function subtractBy($number){
        return $this->answer - $number;
    }
}

?>

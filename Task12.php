<?php

namespace src;

class Task12
{
    private $num1;
    private $num2;
    private $answer;

    public function __construct(int $num1, int $num2)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }

    public function __toString()
    {
        return $this->answer;
    }

    public function add(): Task12
    {
        $this->answer = $this->num1 + $this->num2;

        return $this;
    }

    public function multiply(): Task12
    {
        $this->answer = $this->num1 * $this->num2;

        return $this;
    }

    public function divide(): Task12
    {
        if ($this->num2 == 0) {
            throw new \InvalidArgumentException();
        }
        $this->answer = $this->num1 / $this->num2;

        return $this;
    }

    public function subtract(): Task12
    {
        $this->answer = $this->num1 - $this->num2;

        return $this;
    }

    public function divideBy($number): Task12
    {
        if ($number == 0) {
            throw new \InvalidArgumentException();
        }
        $this->answer = $this->answer / $number;

        return $this;
    }

    public function addBy($number): Task12
    {
        $this->answer = $this->answer + $number;

        return $this;
    }

    public function multiplyBy($number): Task12
    {
        $this->answer = $this->answer * $number;

        return $this;
    }

    public function subtractBy($number): Task12
    {
        $this->answer = $this->answer - $number;

        return $this;
    }
}

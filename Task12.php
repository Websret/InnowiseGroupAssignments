<?php

namespace src;

class Task12
{
    private int $num1;
    private int $num2;
    private int|float|string $answer;

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

    public function divideBy($number): int|float|string
    {
        if ($number == 0) {
            throw new \InvalidArgumentException();
        }

        return $this->answer / $number;
    }

    public function addBy($number): int|float
    {
        return $this->answer + $number;
    }

    public function multiplyBy($number): int|float
    {
        return $this->answer * $number;
    }

    public function subtractBy($number): int|float
    {
        return $this->answer - $number;
    }
}

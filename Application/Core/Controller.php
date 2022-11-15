<?php

namespace Application\Core;

use Application\Models\Car;
use Application\Repositories\CarRepository;

abstract class Controller
{
    public View $view;

    protected Car $cars;

    protected CarRepository $carRepository;

    public function __construct(?array $route = [])
    {
        $this->view = new View($route);
        $this->cars = new Car();
        $this->carRepository = new CarRepository();
    }
}

<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Repositories\CarRepository;

class MainController extends Controller
{
    private CarRepository $carRepository;

    public function __construct()
    {
        parent::__construct();
        $this->carRepository = new CarRepository();
    }

    public function index(): void
    {
        $averagePriceSoldCars = $this->carRepository->getAveragePriceSoldCars();
        $averagePriceSoldToday = $this->carRepository->getAveragePriceSoldCarsToday();
        $unsoldModels = $this->carRepository->getAllCurrentlySaleModels();
        $soldCarsLastYear = $this->carRepository->getSoldCarsLastYear();
        $unsoldCars = $this->carRepository->getUnsoldCars();
        $vars = [
            'averagePriceSoldCars' => $averagePriceSoldCars[0]['average_sold_cars'],
            'averagePriceSoldCarsToday' => $averagePriceSoldToday[0]['average_sold_cars_today'],
            'modelsList' => $unsoldModels,
            'soldCarsLastYearArray' => $soldCarsLastYear,
            'unsoldCarsArray' => $unsoldCars,
        ];
        $this->view->render('main/index', $vars);
    }
}

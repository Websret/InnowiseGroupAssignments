<?php

namespace Application\Repositories;

use Application\Models\Car;

class CarRepository
{
    private Car $car;

    private string $startDate;

    private string $endDate;

    private string $todayDate;

    public function __construct()
    {
        $this->car = new Car();
    }

    public function getAllCurrentlySaleModels(): array
    {
        return $this->car
            ->select('model')
            ->join('statuses', 'showroom_cars.sold_status', '=', 'statuses.id')
            ->join('vehicle_directory', 'vehicle_directory.id', '=', 'showroom_cars.vehicle_id')
            ->where('sold_status = 2')
            ->get();
    }

    public function getSoldCarsLastYear(): array
    {
        $this->getDate();
        return $this->car
            ->select('date_of_sale,')
            ->count('model', 'number_cars_sold')
            ->join('statuses', 'showroom_cars.sold_status', '=', 'statuses.id')
            ->join('vehicle_directory', 'vehicle_directory.id', '=', 'showroom_cars.vehicle_id')
            ->where('sold_status = 1', 'date_of_sale')
            ->between("'$this->startDate'", "'$this->endDate'")
            ->groupBy('date_of_sale')
            ->orderBy('date_of_sale', 'DESC')
            ->get();
    }

    private function getDate(): void
    {
        $this->endDate = date("Y-m-d", strtotime('first day of January ' . date('Y')));
        $this->startDate = date("Y-m-d", strtotime('first day of January ' . date('Y') - 1));
    }

    public function getUnsoldCars(): array
    {
        return $this->car
            ->select('model', 'year_of_production', 'color', 'price')
            ->join('vehicle_directory', 'vehicle_directory.id', '=', 'showroom_cars.vehicle_id')
            ->join('statuses', 'statuses.id', '=', 'showroom_cars.sold_status')
            ->where('sold_status = 2')
            ->get();
    }

    public function getAveragePriceSoldCars(): array
    {
        return $this->car
            ->select('')
            ->other('FORMAT(AVG(DISTINCT price),0)', 'average_sold_cars')
            ->where('sold_status = 1')
            ->get();
    }

    public function getAveragePriceSoldCarsToday(): array
    {
        $this->getTodayDate();
        return $this->car
            ->select('')
            ->other('IFNULL(FORMAT(AVG(DISTINCT price), 0), 0)', 'average_sold_cars_today')
            ->where('sold_status = 1', "date_of_sale ='$this->todayDate'")
            ->get();
    }

    private function getTodayDate(): void
    {
        $this->todayDate = date('Y-m-d');
    }
}

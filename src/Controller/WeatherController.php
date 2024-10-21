<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(Location $location, MeasurementRepository $repository): Response
    {
        $measurements = $repository->findByLocation($location);

        if (empty($measurements)) {
            throw new \Exception('No measurements found for this location.');
        }

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
    #[Route('/weather/{country}/{city}', name: 'app_weather_country_city', requirements: ['city' => '[a-zA-Z\-\s]+', 'country' => '[A-Z]{2}'])]
    public function cityCountry(Location $location, MeasurementRepository $repository, string $country): Response
    {
        $measurements = $repository->findByCountryAndCity($location, $country);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}


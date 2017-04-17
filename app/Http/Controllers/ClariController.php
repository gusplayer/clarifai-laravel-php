<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use \DarrynTen\Clarifai\Clarifai;
use \DarrynTen\Clarifai\Repository;
use \DarrynTen\Clarifai\Entity;


class ClariController extends Controller
{

    public function prueba()
    {

      $clarifai = new Clarifai(
      'retT2FglVE9UIlW_TL0Msi9EJmue4XZauX1pHnII',
      'V1LPSqKt8GFNNI-KLXRf6yDypkpD45m5k9Kgp9K_'
      );

$modelResult = $clarifai->getModelRepository()->predictUrl(
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhKLXujhUsSRAT49aLdAvUsGBZvFMo2v14KQCPObyelJ4rfe3j',
\DarrynTen\Clarifai\Repository\ModelRepository::GENERAL
);

echo json_encode($modelResult);
    }
}

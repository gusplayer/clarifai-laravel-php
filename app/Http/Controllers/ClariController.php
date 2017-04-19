<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Conceptos;

use \DarrynTen\Clarifai\Clarifai;
use \DarrynTen\Clarifai\Repository;
use \DarrynTen\Clarifai\Entity;

use Illuminate\Http\Request;


class ClariController extends Controller
{

    public function enviarImagenClarifai()
    {
        $clarifai = new Clarifai(
        'retT2FglVE9UIlW_TL0Msi9EJmue4XZauX1pHnII',
        'V1LPSqKt8GFNNI-KLXRf6yDypkpD45m5k9Kgp9K_'
        );

        $modelResult = $clarifai->getModelRepository()->predictUrl(
        'http://static.iris.net.co/dinero/upload/images/2007/12/7/55251_143619_1.jpg',
        \DarrynTen\Clarifai\Repository\ModelRepository::GENERAL
        );

        return json_encode($modelResult);
    }


    public function recibirConcepto()
    {
         $conceptos = $this->enviarImagenClarifai();

        //pasamos nuestro Json a un array de objetos
        $data = json_decode($conceptos);

        $conceptoClarifai = $data->outputs[0]->data->concepts[0]->name;
        $valorClarifai = $data->outputs[0]->data->concepts[0]->value;

        //comparamos si existe un concepto claro en la imagen
        if($valorClarifai>0.5)
        {
              // se tiene un puntaje mayor al 50& significa que se encuentra el concepto
              //buscamos en la base de datos si el concepto tiene un contenido
              $conceptoDB = Conceptos::where('concepto',$conceptoClarifai)->first();
              return $conceptoDB->contenido;
              //Verificamos si nos arroja algun resultado
              if($conceptoDB)
              {return "algo";}
              //no se encontro coincidencia de conceptos en la DB
              else {
                return "No hay coincidencia de este concepto en la base de datos";
              }
        return $conceptoDB->contenido;
        }
        elseif($valorClarifai>0.1)
        {
        return 'posible '.$conceptoClarifai;
        }
        else
        {
        return 'no se encuentra '.$conceptoClarifai;
        }
    }


    public function recibirImagen(Request $request)
    {
        $imagen = $request->imagen;
        return \Response::json(['contenido' => 'Sorry, we can\'t find that.'.$imagen], 200);
    }

    public function recibirImagen2()
    {
        $imagen = 'prueba por GET';
        return \Response::json(['contenido' => 'Sorry, we can\'t find that.'.$imagen], 200);
    }

}

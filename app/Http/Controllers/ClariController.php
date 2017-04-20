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

    public function enviarImagenClarifai($imagen)
    {
        $clarifai = new Clarifai(
        'retT2FglVE9UIlW_TL0Msi9EJmue4XZauX1pHnII',
        'V1LPSqKt8GFNNI-KLXRf6yDypkpD45m5k9Kgp9K_'
        );

        list(, $imagen) = explode(';', $imagen);
        list(, $imagen) = explode(',', $imagen);

        $modelResult = $clarifai->getModelRepository()->predictEncoded(
        $imagen,
        \DarrynTen\Clarifai\Repository\ModelRepository::GENERAL
        );

        return json_encode($modelResult);
    }


    public function recibirConcepto(Request $request)
    {
        $conceptos = $this->enviarImagenClarifai($request->imagen);

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
              //Verificamos si nos arroja algun resultado
              if($conceptoDB)
              {
                return \Response::json(['contenido' => 'Se encontro este concepto en la bd '.$conceptoDB->contenido], 200);
              }
              //no se encontro coincidencia de conceptos en la DB
              else {
                return \Response::json(['contenido' => 'Base de datos no encontro concepto '.$conceptoClarifai], 200);
              }
        }
        //el puntaje es muy bajo, no se busca en la base de datos y se pide tomar nueva foto
        elseif($valorClarifai>0.1)
        {
        return \Response::json(['contenido' => 'posible pero no suficiente '.$conceptoClarifai], 200);
        }
        //no se encuentra o es demasiado bajo el puntaje
        else
        {
        return \Response::json(['contenido' => 'no se encuentra concepto '], 200);
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

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Conceptos;

use \DarrynTen\Clarifai\Clarifai;
use \DarrynTen\Clarifai\Repository;
use \DarrynTen\Clarifai\Entity;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ClariController extends Controller
{

    public function enviarImagenClarifai($imagen)
    {
        $clarifai = new Clarifai(
        'ESMvH4JRAYm2qQB-as6xuCtKaX1IKNn1W7WERGV3',
        'NjpLjPiGbCkqgmlc_CHZWvLBrj1Gw8aOH23XeH4K'
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
        if($valorClarifai>0.2)
        {
              // se tiene un puntaje mayor al 50& significa que se encuentra el concepto
              //buscamos en la base de datos si el concepto tiene un contenido
              $conceptoDB =
              Conceptos::where('concepto',$conceptoClarifai)
              ->where('disponible','1')
              ->first();
              //Verificamos si nos arroja algun resultado
              if($conceptoDB)
              {
                return \Response::json(['tipo_contenido' => $conceptoDB->tipo_contenido,'contenido'=> $conceptoDB->contenido], 200);
              }
              //no se encontro coincidencia de conceptos en la DB
              else {
                return \Response::json(['fallido' => 'No se encontro contenido para esta imagen'], 200);
              }
        }
        //el puntaje es muy bajo, no se busca en la base de datos y se pide tomar nueva foto
        elseif($valorClarifai>0.09)
        {
        return \Response::json(['contenido' => 'La imagen no es suficientemente clara para analizarla ¿Podrías tomar la foto nuevamente?'], 200);
        }
        //no se encuentra o es demasiado bajo el puntaje
        else
        {
        return \Response::json(['contenido' => 'No se encontro contenido para esta imagen '], 200);
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

    public function conceptos()
    {
        $conceptos = DB::table('concepts')->get();

        return view('panel.conceptos.index', ['conceptos' => $conceptos]);
    }

    public function create()
    {
        return view('panel.conceptos.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'imagen_concepto' => 'required|image',
            'concepto' => 'required',
            'tipo' => 'required'
        ]);

        if ($request->tipo != 0) {
            if ($request->image) {
                $this->validate($request, [
                    'image' => 'required|image'
                ]);

                $filex = $request->imagen_concepto;
                $filenamex = $filex->getClientOriginalName();
                $name_modifiedx = $random = str_random(3) . date('is') . $filenamex;

                $file = $request->image;
                $filename = $file->getClientOriginalName();
                $name_modified = $random = str_random(3) . date('is') . $filename;

                if (Image::make($file->getRealPath())->save('contenido/' . $name_modified)) {

                    Image::make($filex->getRealPath())->resize('500', '300')->save('images/' . $name_modifiedx);

                    DB::table('concepts')->insert([
                        'imagen_concepto' => $name_modifiedx,
                        'concepto' => $request->concepto,
                        'tipo_contenido' => $request->tipo,
                        'contenido' => $name_modified,
                        'disponible' => $request->disponible
                    ]);

                    return redirect()->back()->with(['success' => 'Guardado correctamente']);
                }

            } else {

                $this->validate($request, [
                    'video' => 'required'
                ]);

                $file = $request->imagen_concepto;
                $filename = $file->getClientOriginalName();
                $name_modified = $random = str_random(3) . date('is') . $filename;

                if (Image::make($file->getRealPath())->resize('500', '300')->save('images/' . $name_modified)) {

                    DB::table('concepts')->insert([
                        'imagen_concepto' => $name_modified,
                        'concepto' => $request->concepto,
                        'tipo_contenido' => $request->tipo,
                        'contenido' => $request->video,
                        'disponible' => $request->disponible
                    ]);

                    return redirect()->back()->with(['success' => 'Guardado correctamente']);
                }
            }
        } else {
            return redirect()->back()->with(['error' => 'Seleccione algún tipo de contenido (Imágen, Video)']);
        }
    }

    public function destroy(\Illuminate\Http\Request $request)
    {
        $concepto = DB::table('concepts')->where('id', $request->id)->first();

        if (file_exists('images/' . $concepto->imagen_concepto)) {
            unlink('images/' . $concepto->imagen_concepto);
        }

        if (file_exists('contenido/' . $concepto->contenido)) {
            unlink('contenido/' . $concepto->contenido);
        }

        DB::table('concepts')->delete($request->id);

        return redirect()->back()->with('success', 'Eliminado con exito');
    }


}

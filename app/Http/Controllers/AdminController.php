<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
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

    public function changeStatus($id, $status)
    {
        if ($status == 1 || $status == 0) {
            $concepto = DB::table('concepts')->where('id', $id)->update([
                'disponible' => $status
            ]);

            return redirect()->back()->with('success', 'Estado cambiado con exito');
        }

        return redirect()->back()->with('error', 'Ha ocurrido un error');
    }

    public function conceptsEdit(Request $request)
    {
        $concepto = DB::table('concepts')->where('id', $request->id)->first();

        if ($request->image) {
            $this->validate($request, [
                'image' => 'required|image'
            ]);

            if (file_exists('contenido/' . $concepto->contenido)) {
                unlink('contenido/' . $concepto->contenido);
            }

            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $name_modified = $random = str_random(3) . date('is') . $filename;

            if (Image::make($file->getRealPath())->save('contenido/' . $name_modified)) {

                $concepto = DB::table('concepts')->where('id', $request->id)->update([
                    'contenido' => $name_modified,
                    'disponible' => $request->disponible,
                    'tipo_contenido' => $request->tipo
                ]);

                return redirect()->back()->with(['success' => 'Guardado correctamente']);
            }
        }
    }

    public function edit($id)
    {
        $concepto = DB::table('concepts')->where('id', $id)->first();

        return view('panel.conceptos.edit', ['concepto' => $concepto]);
    }

    public function update(Request $request)
    {
        $concepto = DB::table('concepts')->where('id', $request->id)->first();

        if ($request->image) {
            $this->validate($request, [
                'image' => 'required|image'
            ]);

            if (file_exists('contenido/' . $concepto->contenido)) {
                unlink('contenido/' . $concepto->contenido);
            }

            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $name_modified = $random = str_random(3) . date('is') . $filename;

            if (Image::make($file->getRealPath())->save('contenido/' . $name_modified)) {

                $concepto = DB::table('concepts')->where('id', $request->id)->update([
                    'contenido' => $name_modified,
                    'disponible' => $request->disponible,
                    'tipo_contenido' => $request->tipo
                ]);

                return redirect()->back()->with(['success' => 'Guardado correctamente']);
            }
        }

        if ($request->video) {
            $this->validate($request, [
                'video' => 'required|url'
            ]);

            $concepto = DB::table('concepts')->where('id', $request->id)->update([
                'contenido' => $request->video,
                'disponible' => $request->disponible,
                'tipo_contenido' => $request->tipo
            ]);

            return redirect()->back()->with(['success' => 'Guardado correctamente']);
        }
    }
}

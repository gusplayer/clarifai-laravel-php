<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('panel.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('panel.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('status', 'Usuario creado con exito');
    }

    public function updateUser(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::find($request->id);
        $user->name = $request->nombre;

        if ($user->email == $request->email) {
            $user->email = $request->email;
        } else {
            $users = User::where('email', $request->email)->first();
            if ($users) {
                return redirect()->back()->with('error', 'Este usuario ya existe');
            } else {
                $user->email = $request->email;
            }
        }

        if ($request->password) {

            $this->validate($request, [
                'password' => 'required',
                'password_confirmation' => 'required|same:password'
            ]);

            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('status', 'Usuario editado con exito');
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return redirect()->back()->with('status', 'Usuario editado con exito');
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $input      = Input::all();
        $validation = \Validator::make($input, User::$rules);
        if ($validation->fails()) {
            return \Redirect::route('users.create')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'There were validation errors.');
        }
        User::create($input);
        return \Redirect::route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return \Redirect::route('users.index');
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $input      = Input::all();
        $validation = \Validator::make($input, User::$rules);
        if ($validation->fails()) {
            return \Redirect::route('users.edit', $id)
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'There were validation errors.');
        }
        $user = User::find($id);
        $user->update($input);
        return \Redirect::route('users.index');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return \Redirect::route('users.index');
    }
}

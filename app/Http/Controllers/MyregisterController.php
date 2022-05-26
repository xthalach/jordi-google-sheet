<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Revolution\Google\Sheets\Facades\Sheets;

class MyregisterController extends Controller
{
    public function create()
    {
            return view('register.create');
    }

    public function store()
    {
       // create the user
        //var_dump(request()->all());
        //return request()->all();
        $attributes = request()->validate([
            'name'=> 'required|max:255',
            'username'=> 'required|max:255|min:3',
            'email'=> 'required|email|max:255|unique:users,email',
            'password'=> 'required|min:7|max:255'
        ]);

        User::create($attributes);

        Sheets::spreadsheet(config('sheets.post_spreadsheet_id'))
            ->sheet(config('sheets.post_sheet_id'))
            ->append([
                array_values($attributes)
            ]);


        //$user->setPasswordAttribute('password');
        return redirect('/')->with('success','Your acount has been created');
    }
}

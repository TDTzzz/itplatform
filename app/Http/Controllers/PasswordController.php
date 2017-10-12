<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function update(Request $request)
    {

        if(Hash::check($request->get('old_password'),user()->password)){
            user()->password=bcrypt($request->get('password'));
            user()->save();
            flash('密码修改成功','success');

            return back();
        }
        flash('密码修改失败','danger');
        return back();
    }
}

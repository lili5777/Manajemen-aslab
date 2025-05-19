<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function proses_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credential = $request->only('email', 'password');
        if (Auth::attempt($credential)) {
            return redirect()->intended('admin');
        }
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Email atau Password Anda Salah']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }


    public function proses_register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'stb' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'name.required' => 'The name field is required.',
            'stb.required' => 'The STB field is required.',
            'stb.unique' => 'This STB is already registered.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'password.required' => 'The password field is required.'
        ]);

        $request['role'] = 'mahasiswa';
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->all());
        auth()->login($user);

        return redirect()->route('admin');
    }
}

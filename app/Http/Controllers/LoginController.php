<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CaptchaHelper;

class LoginController extends Controller
{
    public function index()
    {
        $question = CaptchaHelper::generate();
        session(['captcha_question' => $question]);

        return view('login', [
            'title' => 'Login',
            'captcha_question' => $question,
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'captcha'  => ['required', 'numeric'],
        ]);

        // Cek captcha
        if (!CaptchaHelper::check($request->captcha)) {
            // Refresh captcha
            $question = CaptchaHelper::generate();
            session(['captcha_question' => $question]);
        
            return back()
                ->withErrors(['captcha' => 'Jawaban captcha salah.'])
                ->withInput();
        }
        

        // Proses autentikasi user
        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika autentikasi gagal
        return back()
            ->withErrors(['username' => 'Username atau password salah.'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();        
        $request->session()->invalidate();
        $request->session()->regenerateToken();        
        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{    
    // Menampilkan form perubahan password
    public function showChangePasswordForm()
    {
        return view('dashboard.change-password');
    }

    // Proses perubahan password
    public function updatePassword(Request $request)
    {
        // Validasi hanya password lama dulu
        $request->validate([
            'current_password' => 'required',
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        // Validasi password baru setelah password lama lolos
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Update password
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        Auth::logout();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
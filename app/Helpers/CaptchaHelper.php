<?php

namespace App\Helpers;

class CaptchaHelper
{
    /**
     * Generate captcha question and store the answer in session.
     */
    public static function generate()
    {
        $a = rand(1, 10);
        $b = rand(1, 10);
        $operator = rand(0, 1) ? '+' : '-';
        $question = "$a $operator $b";
        $answer = $operator === '+' ? $a + $b : $a - $b;

        // Simpan di session dengan namespace khusus
        session()->put('captcha.answer', $answer);

        return $question;
    }

    /**
     * Check if user input matches the captcha answer.
     */
    public static function check($input)
    {
        // Pastikan dibandingkan sebagai integer
        return intval(session()->get('captcha.answer')) === intval($input);
    }
}


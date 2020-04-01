<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function forgot_password(ForgotPasswordRequest $request)
    {
        try {

            $email = $request->input('email');

            if (User::where('email', $email)->doesntExist()) {
                return response([
                    'message' => "User Not Found"
                ], 404);
            }

            $token = Str::random(10);

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            Mail::send('mail.forgot_password', ['token' => $token], function (Message $message) use ($email) {
                $message->to($email);
                $message->subject('Reset your password');
            });

            return response([
                'message' => 'Check your email'
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function reset_password(ResetPasswordRequest $request)
    {
        try {

            $token = $request->input('token');

            if (!$password_reset_table = DB::table('password_resets')->where('token', $token)->first()) {
                return response([
                    'message' => 'Invalid Token'
                ], 400);
            }

            if (!$user = User::where('email', $password_reset_table->email)->first()) {
                return response([
                    'message' => "Email not found"
                ], 404);
            }

            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response([
                'message' => 'success'
            ]);

        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}

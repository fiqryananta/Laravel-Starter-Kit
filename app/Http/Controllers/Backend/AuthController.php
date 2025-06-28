<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\ConfirmToken;
use App\Models\ResetPasswordToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if (post_request($request)) {

            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            
            $message = [
                'email.required' => 'Email Harus Diisi',
                'email.email' => 'Email Tidak Valid',
                'password.required' => 'Password Harus Diisi',
    
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $credentials = ['email' => $request->email, 'password' => $request->password];

            if (Auth::attempt($credentials)) {

                $data = [
                    'redirectTo' => route('dashboard.index')
                ];

                return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);

            } else {

                return api_response(422, false, 'Email dan Password Tidak Sesuai');

            }

        } else {
        
            $this->data['title'] = 'Login - ' . env('APP_NAME');
    
            return view('backend/authentication/login', $this->data);

        }

    }
    
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('authentication.login');
    }
    
    public function forgot_password(Request $request, $token = null)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if ($token) {

            $resetPasswordToken = ResetPasswordToken::whereToken($token)->firstOrFail();

            if ($resetPasswordToken->expired_at >= Carbon::now()) {

                $this->data['status'] = true;

            } else {

                $this->data['status'] = false;

            }

            $this->data['title'] = 'Ganti Kata Sandi - ' . env('APP_NAME');
            $this->data['token'] = $resetPasswordToken->token;

            return view('backend/authentication/change_password', $this->data);

        } else {

            if (post_request($request)) {

                $rules = [
                    'email' => 'required|email',
                ];
                
                $message = [
                    'email.required' => 'Email Harus Diisi',
                    'email.email' => 'Email Tidak Valid',
                ];
                
                $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
                if ($validate) {
                    return api_response(422, false, $validate, null);
                }

                $user = User::whereEmail($request->email)->first();

                if ($user) {
                    
                    ResetPasswordToken::whereEmail($user->email)->delete();

                    ResetPasswordToken::create([
                        'email' => $request->email,
                        'token' => generateToken(),
                        'expired_at' => Carbon::now()->addMinutes(30),
                    ]);
                }

                $data = [
                    'redirectTo' => route('authentication.login')
                ];

                return api_response(200, true, 'Tautan Mengganti Kata Sandi Akan Dikirim Ke Email Anda Jika Email Yang Anda Masukkan Benar', $data);

            } else {
            
                $this->data['title'] = 'Lupa Kata Sandi - ' . env('APP_NAME');
        
                return view('backend/authentication/forgot_password', $this->data);

            }

        }

    }
    
    public function change_password(Request $request, $token)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if (post_request($request)) {
            $rules = [
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/'
                ],
            ];
            
            $message = [
                'password.required' => 'Password Harus Diisi',
                'password.min' => 'Password harus minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
    
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $resetPasswordToken = ResetPasswordToken::whereToken($token)->firstOrFail();

            if ($resetPasswordToken->expired_at >= Carbon::now()) {

                $user = User::whereEmail($resetPasswordToken->email)->firstOrFail();

                $userUser = $user->update([ 
                    'password' => Hash::make($request->password),
                ]);

                if ($userUser) {

                    ResetPasswordToken::whereEmail($user->email)->delete();

                    $data = [
                        'redirectTo' => route('authentication.login')
                    ];

                    return api_response(200, true, 'Kata Sandi Berhasil Diganti, Silahkan Login Menggunakan Email dan Kata Sandi Baru Anda', $data);

                } else {

                    return api_response(422, false, 'Kata Sandi Gagal Diganti, Silahkan Coba Lagi');

                }

            } else {

                return api_response(422, false, 'Tautan Sudah Tidak Berlaku, Silahkan Kirim Ulang Tautan Untuk Mengganti Kata Sandi');

            }

        }

    }

    public function registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if (post_request($request)) {

            $rules = [
                'company_name' => 'required',
                'email' => 'required|string|email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/'
                ],
            ];
            
            $message = [
                'company_name.required' => 'Nama Perusahaan Harus Diisi',
                'email.required' => 'Email Harus Diisi',
                'email.email' => 'Email Tidak Valid',
                'password.required' => 'Password Harus Diisi',
                'password.min' => 'Password harus minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
    
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $hasExist = User::where('email', $request->email)->first();
            if ($hasExist) {
                return api_response(422, false, 'Email Sudah Digunakan Oleh Pengguna Lain');
            }

            $user = User::create([ 
                'name' => $request->company_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {

                ConfirmToken::create([
                    'email' => $request->email,
                    'token' => generateToken(),
                    'expired_at' => Carbon::now()->addMinutes(30),
                ]);

                $data = [
                    'redirectTo' => route('authentication.confirm_email')
                ];

                return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);

            } else {

                return api_response(422, false, 'Silahkan Coba Lagi');

            }


        } else {
        
            $this->data['title'] = 'Daftar Akun - ' . env('APP_NAME');
    
            return view('backend/authentication/registration', $this->data);

        }

    }
    
    public function confirm_email(Request $request, $token)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        
        $confirmToken = ConfirmToken::whereToken($token)->firstOrFail();
    
        $this->data['title'] = 'Konfirmasi Email - ' . env('APP_NAME');
        $this->data['token'] = $confirmToken->token;

        return view('backend/authentication/confirm_email', $this->data);

    }
    
    public function verify_email(Request $request, $token)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        $confirmToken = ConfirmToken::whereToken($token)->firstOrFail();

        if ($confirmToken->expired_at >= Carbon::now()) {

            $this->data['status'] = true;
            
            ConfirmToken::whereEmail($confirmToken->email)->delete();

        } else {

            $this->data['status'] = false;

        }

        $this->data['title'] = 'Konfirmasi Email - ' . env('APP_NAME');
        $this->data['token'] = $confirmToken->token;

        return view('backend/authentication/confirm_email_token', $this->data);

    }

    public function confirm_email_resend(Request $request, $token)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if (post_request($request)) {

            $confirmToken = ConfirmToken::whereToken($token)->firstOrFail();
                
            ConfirmToken::whereEmail($confirmToken->email)->delete();

            $newToken = ConfirmToken::create([
                'email' => $confirmToken->email,
                'token' => generateToken(),
                'expired_at' => Carbon::now()->addMinutes(30),
            ]);

            $data = [
                'redirectTo' => route('authentication.confirm_email', $newToken->token)
            ];

            return api_response(200, true, 'Silahkan Periksa Emali Anda', $data);

        }

    }
    
    public function terms_of_service(Request $request)
    {
    
        $this->data['title'] = 'Terms Of Service - ' . env('APP_NAME');

        return view('backend/authentication/terms_of_service', $this->data);

    }
    
    public function privacy_policy(Request $request)
    {
    
        $this->data['title'] = 'Privacy Policy - ' . env('APP_NAME');

        return view('backend/authentication/privacy_policy', $this->data);

    }
}

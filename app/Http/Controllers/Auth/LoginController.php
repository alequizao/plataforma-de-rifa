<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Aceita login por e-mail OU por nome de usuario simples (ex.: "alequizao").
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Descobre se o valor informado e um e-mail ou um usuario simples.
     */
    protected function loginField(Request $request)
    {
        return filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'name';
    }

    protected function credentials(Request $request)
    {
        return [
            $this->loginField($request) => $request->input($this->username()),
            'password' => $request->input('password'),
        ];
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $field = $this->loginField($request);

        $user = User::where($field, $request->input($this->username()))->first();

        if ($user && ! $user->status) {
            throw ValidationException::withMessages([
                $this->username() => ['Sua conta está em processo de validação, entraremos em contato.'],
            ]);
        }

        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}

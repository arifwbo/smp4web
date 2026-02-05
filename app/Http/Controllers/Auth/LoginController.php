<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ActivityLogger;
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
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
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
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        ActivityLogger::log('auth.login', 'Login berhasil');

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    protected function loggedOut(Request $request)
    {
        ActivityLogger::log('auth.logout', 'Logout berhasil');
    }

    protected function credentials(Request $request): array
    {
        return [
            $this->username() => $request->get($this->username()),
            'password' => $request->get('password'),
            'is_active' => true,
        ];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this->username(), $request->get($this->username()))->first();

        if ($user && ! $user->is_active) {
            throw ValidationException::withMessages([
                $this->username() => __('Akun Anda dinonaktifkan. Silakan hubungi administrator.'),
            ]);
        }

        return parent::sendFailedLoginResponse($request);
    }

    protected function maxAttempts(): int
    {
        return 5;
    }

    protected function decayMinutes(): int
    {
        return 1;
    }
}

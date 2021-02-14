<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
   
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::check() && Auth::user()->role->id == 1)
        {
            $this->redirectTo = route('admin.dashboard');
        }
        else
        {
            $this->redirectTo = route('user.dashboard');
        }

        $this->middleware('guest');
    }

    // Overridden method from ResetsPasswords Trait to change Password Length Validation
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $this->broker()->validator(function (array $credentials){
            [$password, $confirm] = [
                $credentials['password'],
                $credentials['password_confirmation'],
            ];
            return $password === $confirm && mb_strlen($password) >= 5;
        });
                
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    // Overridden method from ResetsPasswords Trait to change Password Length Validation
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
        ];
    }
}

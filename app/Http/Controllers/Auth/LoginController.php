<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // Custom Controller
    protected function authenticated($request, $user)
    {
        switch ($user->role) {
            case 'Admin':
            case 'Traveler':
            case 'Trader':
                return redirect()->route('backstage.index');
            default:
                return redirect()->route('backstage.index');
        }
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $userSocialite = Socialite::driver('facebook')->stateless()->user();

        $ckeck = User::where('email', $userSocialite->email)->first();

        if ($ckeck) {
            Auth::login($ckeck);
            return redirect()->route('backstage.index');

        } else {
            $user = new User;
            $user->name = $userSocialite->name;
            $user->email = $userSocialite->email;
            $user->password = uniqid();
            $user->save();

            Auth::login($user);
            return redirect()->route('backstage.index');
        };
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\GeneralSettings;
use App\Http\Controllers\Controller;
use App\Provider;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class AuthController extends Controller
{

    protected $redirectTo = '/user/home';

    protected $field = ['first_name', 'last_name', 'email', 'gender', 'birthday', 'location'];
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)

    {

        $provider = Provider::where('provider', $provider)->first();

        Config::set('services.' . $provider->provider, [

            'client_id' => $provider->client_id,

            'client_secret' => $provider->client_secret,

            'redirect' => url('/').'/auth/' . $provider->provider . '/callback',

        ]);

        if ($provider->provider == 'facebook') {
            return Socialite::driver($provider->provider)->fields($this->field)->scopes([
                'email', 'user_birthday', 'user_location'
            ])->redirect();
        } else {
            return Socialite::driver($provider->provider)->scopes([
                'https://www.googleapis.com/auth/userinfo.email',
                'profile',
                'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/plus.me'
            ])->redirect();
        }

    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)

    {

        try {

            $provider = Provider::where('provider', $provider)->first();

            Config::set('services.' . $provider->provider, [

                'client_id' => $provider->client_id,

                'client_secret' => $provider->client_secret,

                'redirect' => url('/').'/auth/' . $provider->provider . '/callback',

            ]);

            if ($provider->provider == 'google') {
                $userSocial = Socialite::driver($provider->provider)->stateless()->user();
            } else {
                $userSocial = Socialite::driver($provider->provider)->fields($this->field)->user();
            }

            $authUser = $this->findOrCreateUser($userSocial, $provider->provider);
            Auth::login($authUser, true);

            return redirect($this->redirectTo);

        } catch (\Exception $e) {
            return redirect('login')->withErrors('Error! Failed To Connect.' . $e->getMessage());
        }

    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)

    {

        $authUser = User::where(['provider' => $provider, 'provider_id' => $user->id])->first();

        if ($authUser) {

            return $authUser;

        }

        $photo = uniqid() . '.png';

        $bin = @file_get_contents($user->getAvatar());

        @file_put_contents('assets/images/user/' . $photo, $bin);

        $basic = GeneralSettings::first();

        $email_verify = 1;


        $verification_code  = strtoupper(Str::random(6));
        $sms_code  = strtoupper(Str::random(6));
        $email_time = Carbon::parse()->addMinutes(5);
        $phone_time = Carbon::parse()->addMinutes(5);

        $param = [
            'fname' => ($user->getName() != null)?$user->getName():$provider . '_' . $user->id,
            'email' => ($user->getEmail() != null)?$user->getEmail():$user->id . '@' . $provider,
            'phone' => '',
            'username' => $provider . '_' . $user->id,
            'email_verify' => $email_verify,
            'verification_code' => $verification_code,
            'sms_code' => $sms_code,
            'email_time' => $email_time,
            'phone_verify' => 1,
            'phone_time' => $phone_time,
            'password' => Hash::make($provider . '_' . $user->id),
            'image' => $photo,
            'provider' => $provider,
            'provider_id' => $user->id,
        ];

        // return dd($param);

        return User::create($param);

    }
}

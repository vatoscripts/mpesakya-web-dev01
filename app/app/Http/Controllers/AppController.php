<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GuzzleController as GuzzleController;
use session;
use Log;

class AppController extends GuzzleController
{
    public function __construct()
    {
        parent::__constructor();
    }

    public function index()
    {
        if(session::has('Authenticated'))
        {
            return redirect('home');
        }
        else {
            return view('auth.login');
        }
    }

    public function home()
    {
        return view('dashboard.home');
    }

    public function otp()
    {
        return view('auth.otp');
    }

    public function resetPassword()
    {
        return view('auth.reset-password');
    }

    public function recoverPassword()
    {
        return view('auth.recover-password');
    }

    public function logoutUser()
    {
        $body = [
            'UserID' => $this->user['UserID']
        ];

        $url = 'LogOut';

        $data = $this->postRequest($url, $body);

        Log::channel('Auth')->debug(['Request' => $body, 'Response' => $data]);

        if(is_array($data) && $data['ID'] === 0)
        {
            session::flush();

            return redirect()->route('login')->withInfo('You have been  logged out !');
        }
        else {
            Log::emergency(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);
            return redirect('home');
        }
    }

}

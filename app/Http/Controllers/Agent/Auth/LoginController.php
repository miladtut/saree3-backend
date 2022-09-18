<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use App\CentralLogics\Helpers;
use Brian2694\Toastr\Facades\Toastr;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:agent', ['except' => 'logout']);
    }

    public function login()
    {
        $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('six_captcha', $custome_recaptcha->getPhrase());
        return view('agent-views.auth.login', compact('custome_recaptcha'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                        $response = $value;
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                        $response = \file_get_contents($url);
                        $response = json_decode($response);
                        if (!$response->success) {
                            $fail(translate('messages.ReCAPTCHA Failed'));
                        }
                    },
                ],
            ]);
        } else if(strtolower(session('six_captcha')) != strtolower($request->custome_recaptcha))
        {
            Toastr::error(translate('messages.ReCAPTCHA Failed'));
            return back();
        }

        $agent = Agent::where('email', $request->email)->first();
        if($agent)
        {
            if($agent->stores[0]->status == 0)
            {
                return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors([translate('messages.inactive_vendor_warning')]);
            }

            if (auth('agent')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                return redirect()->route('vendor.dashboard');
            }
        }


        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('agent')->logout();
        return redirect()->route('agent.auth.login');
    }
}

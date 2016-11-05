<?php

namespace Terranet\Administrator;

use App\Http\Controllers\Controller;
use Terranet\Administrator\Middleware\AuthProvider;
use Terranet\Administrator\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        if (! guarded_auth()) {
            $this->middleware(AuthProvider::class);
            $this->middleware('guest', ['except' => 'getLogout']);
        }
    }

    public function postLogin(LoginRequest $request)
    {
        $config = app('scaffold.config');

        // basic login policy
        $credentials = $request->only(
            [
                $config->get('auth_identity', 'username'),
                $config->get('auth_credential', 'password'),
            ]
        );

        // extend auth policy by allowing custom login conditions
        if ($conditions = $config->get('auth_conditions', [])) {
            $credentials = array_merge($credentials, $conditions);
        }

        $remember = (int) $request->get('remember_me', 0);

        if (auth('admin')->attempt($credentials, $remember, true)) {
            if (is_callable($url = $config->get('home_page'))) {
                $url = call_user_func($url);
            }

            return redirect()->intended(url($url));
        }

        return redirect()->back()->withErrors(['Login attempt failed']);
    }

    public function getLogin()
    {
        return view(app('scaffold.template')->auth('login'));
    }

    public function getLogout()
    {
        auth('admin')->logout();

        return redirect()->to(
            url('admin/login')
        );
    }
}

<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;

class MemberAuthController extends Controller {

    protected $loginView = 'member.login';

    public function getLogin() {
        if($this->guard()->check()) {
            return redirect($this->redirectPath());
        }
        return view($this->loginView);
    }

    public function postLogin(Request $request) {
        $credentials = $request->only([
            $this->username(),
            'password'
        ]);

        $remember = $request->get('remember', false);

        if($this->guard()->attempt($credentials, $remember)){
            $request->session()->regenerate();
            return redirect()->route('member.dashboard');
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            'mobile_phone' => 'required',
            'password'        => 'required',
        ]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('member.login');
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return 'Tài khoản hoặc mật khẩu không chính xác';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        admin_toastr(trans('admin.login_successful'));

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'mobile_phone';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('member');/*Khong duoc sua Auth::guard() thanh Admin::guard()*/
    }

    public function register() {
        return view('member.register');
    }

    public function postRegister(Request $request) {
        if (! is_null($request->all()))
        {
            $result = Member::where('mobile_phone', $request->mobile_phone)->first();
            if (!is_null($result)) {
                return back()->withInput()->withErrors([
                    'mobile_phone' => 'Số điện thoại này đã được sử dụng.'
                ]);
            }

            Member::create($request->all());
            return redirect()->route('member.login')->withInput()->withErrors([
                'registed' => trans('admin.register-successed')
            ]);
        }
    }
}

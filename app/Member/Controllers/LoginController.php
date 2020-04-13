<?php

namespace App\Member\Controllers;

use Brazzer\Admin\Facades\Admin;
use Brazzer\Admin\Form;
use Brazzer\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Show view login
     *
     * @return void
     */
    public function login() {
        return view('member.login');
    }

    /**
     * Store login
     *
     * @param Request $request
     * @return void
     */
    public function postLogin(Request $request) {
        $data = $request->all();

        $validator = $this->loginValidator($data);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $credentials = $request->only([
            $this->username(),
            'password'
        ]);
        $remember = $request->get('remember', false);

        $credentials['is_member'] = 1;
        if ($this->guard()->attempt($credentials, $remember)) {
            return redirect()->route('member.dashboard');
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Validator function
     *
     * @param array $data
     * @return boolean
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'mobile'         => 'required',
            'password'       => 'required'
        ], [
            'mobile.required'       => trans('validation.required'),
            'password.required'       => trans('validation.required')
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
            $this->username() => 'required',
            'password'        => 'required',
        ]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('member.login');
    }



    public function getSetting(Content $content){
        $form = $this->settingForm();
        $form->tools(function(Form\Tools $tools){
            $tools->disableList();
        });
        return $content->header(trans('admin.user_setting'))->body($form->edit(Admin::user()->id));
    }

    public function putSetting(){
        return $this->settingForm()->update(Admin::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        $class = config('admin.database.users_model');
        $form = new Form(new $class);
        $form->display('email', trans('admin.email'));
        $form->text('name', trans('admin.name'))->rules('required');
        $form->image('avatar', trans('admin.avatar'));
        if(config('admin.login.email')){
            $form->password('password', trans('admin.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')->default(function($form){
                return $form->model()->password;
            });
        }
        $form->setAction(route('admin.setting'));
        $form->ignore(['password_confirmation']);
        $form->saving(function(Form $form){
            if($form->password && $form->model()->password != $form->password){
                $form->password = bcrypt($form->password);
            }
        });
        $form->saved(function(){
            admin_toastr(trans('admin.update_succeeded'));
            return redirect(route('admin.setting'));
        });

        return $form;
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? 'Tài khoản hoặc mật khẩu không chính xác'
            : 'Tài khoản hoặc mật khẩu không chính xác.';
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
        return 'mobile';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();/*Khong duoc sua Auth::guard() thanh Admin::guard()*/
    }
}

<?php

namespace App\Member\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use Brazzer\Admin\Auth\Database\Role;

class RegisterController extends Controller
{
    protected $service;

    /**
     * Contructator
     *
     * @param AuthService $service
     */
    public function __construct()
    {

    }

    /**
     * Index register
     *
     * @return view
     */
    public function register() {
        return view('member.register');
    }

    /**
     * Handle register account
     *
     * @param Request $request
     * @return void
     */
    public function postRegister(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();

            // Validator
            $validator = $this->validator($data);
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            // Create record
            $data['password']   =   bcrypt($data['password']);
            $data['is_member'] = 1;
            $user = User::create($data);
            $role = Role::where('slug', 'guest')->first();
            if($role){
                $user->roles()->attach($role);
            }

            DB::commit();
            session()->flash('register_success', trans('admin.register_success'));
            return redirect()->route('member.login');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('register_error', trans('admin.register_error'));

            return redirect()->route('admin.register')->withInput();
        }
    }

    /**
     * Validator function
     *
     * @param array $data
     * @return boolean
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'name'           => 'required|min:6',
            'mobile'         => 'required|unique:admin_users,mobile',
            'email'          => [
                'required', 'email', 'unique:admin_users,email'
            ],
            'password'       => 'min:6|confirmed',
            'birthday'  =>  'required',
            'gender'        =>  'required'
        ], [
            'name.required'         => trans('validation.required'),
            'mobile.required'       => trans('validation.required'),
            'mobile.unique'         => trans('validation.mobile.unique'),
            'email.required'        => trans('validation.required'),
            'email.unique'          => trans('validation.email.unique'),
            'email.email'           => trans('validation.email.email'),
            'password.confirmed'    => trans('validation.password.confirmed'),
            'birthday.required'         => trans('validation.required'),
            'gender.required'         => trans('validation.required'),
            'password.min'         => trans('validation.password.min'),
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 9/2/19
 * Time: 6:57 PM
 */

namespace App\Http\Controllers\V1\Authentication\Actions;

use App\Http\Controllers\V1\Actions\BaseAction;
use App\Http\Controllers\V1\Traits\RandomStringGenerator;
use App\Mail\AccountActivation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DoRegister extends BaseAction
{
    protected $generator;
    public function __construct(Request $request, RandomStringGenerator $generator)
    {
        parent::__construct($request);
        $this->generator = $generator;
    }

    public function validation()
    {
        if (($errors = parent::validation()) !== true) {
            return $errors;
        }

        return true;
    }

    public function execute($data = null)
    {
        $name   =   (isset($data['name'])) ?: $this->request->input('name');
        $email  =   (isset($data['email'])) ?: $this->request->input('email');
        $password   =   (isset($data['password'])) ?: $this->request->input('password');

        $code = $this->generator->execute(8);
        $validateCode = $this->checkGeneratedCode($code);

        $user   =   new User();
        $user->name =   $name;
        $user->email    =   $email;
        $user->password =   md5($password);
        $user->verify_code = $validateCode;

        if($user->save()) {
            $token = $user->createToken('Guide')->accessToken;

            $this->sendActivationEmail($user);

            return [
                'user_id'   => $user->id,
                'token' =>  $token,
                'name'  =>  $user->name
            ];
        }

        return ['error' => 'مشکل در سرور، دوباره امتحان کنید.'];
    }

    public function rules()
    {
        return [
            'email' =>  'required|email|unique:users|min:10,max:255',
            'password'  =>  'required|string|min:6,max:100',
            'name'  =>  'required|string|max:100'
        ];
    }

    private function checkGeneratedCode($code)
    {
        $taken = User::where('verify_code', $code)->first();
        if(isset($taken)) {
            $code = $this->generator->execute(8);
            $this->checkGeneratedCode($code);
        }
        return $code;
    }

    private function sendActivationEmail($user)
    {
        Mail::to($user->email)->send(new AccountActivation($user));
    }
}
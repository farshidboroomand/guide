<?php
/**
 * Created by PhpStorm.
 * User: farshid
 * Date: 06/09/2019
 * Time: 14:27
 */

namespace App\Http\Controllers\V1\Authentication\Actions;

use App\Http\Controllers\V1\Actions\BaseAction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifyAccount extends BaseAction
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function execute($data = null)
    {
        $code   =   isset($data['verify_code']) ?: $this->request->verify_code;

        $result = User::whereVerifyCode($code)->update([
            'status'            => 1,
            'email_verified_at' => Carbon::now()
        ]);

        if ($result) {
            return true;
        }
    }

    public function validation()
    {
        if (($errors = parent::validation()) !== true) {
            return $errors;
        }

        return true;
    }

    protected function rules()
    {
        return [
            'verify_code' =>  'string|max:8'
        ];
    }
}
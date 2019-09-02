<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 9/2/19
 * Time: 6:52 PM
 */

namespace App\Http\Controllers\V1\Authentication;


use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Authentication\Actions\DoRegister;
use App\Http\Controllers\V1\Traits\Returner;

class AuthenticationController extends Controller
{
    protected $returner;

    public function __construct(Returner $returner)
    {
        $this->returner = $returner;
    }

    public function register(DoRegister $user)
    {

        // Do Validating
        if (($errors = $user->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                10001,
                $errors,
                "اشکال در مقادیر ورودی"
            );
        }

        $result = $user->execute();

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                10002,
                $result['error'],
                null
            );
        }

        return $this->returner->successReturner(
            200,
            $result,
            'کاربر مورد نظر ایجاد شد.'
        );

    }
}
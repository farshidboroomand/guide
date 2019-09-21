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
use App\Http\Controllers\V1\Authentication\Actions\VerifyAccount;
use App\Http\Controllers\V1\Traits\Returner;

class AuthenticationController extends Controller
{
    protected $returner;

    public function __construct(Returner $returner)
    {
        $this->returner = $returner;
    }

    /**
     * @api {post} api/auth/register Register User
     * @apiName Register User
     * @apiGroup Authentication
     * @apiVersion 1.0.0
     *
     * @apiParam {String} email     User Email.
     * @apiParam {String} password  User Password.
     * @apiParam {String} name      User Name.
     *
     * @apiSuccess {String} message     Message of successfully created user.
     * @apiSuccess {Integer} user_id    User ID.
     * @apiSuccess {String} name        User Name.
     * @apiSuccess {String} token       User Token.
     */
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

    public function verification(VerifyAccount $verify)
    {
        if (($errors = $verify->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                10001,
                $errors,
                "اشکال در مقادیر ورودی"
            );
        }

        $result = $verify->execute();

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
            'حساب کاربری فعال شد.'
        );
    }
}
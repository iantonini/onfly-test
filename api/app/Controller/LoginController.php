<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Users;

class LoginController extends AbstractController
{
    // TODO: colocar 'ONFLY' no .env
    protected $hashKey = 'ONFLY';

    public function login()
    {
        $status = 'error';
        $msg = 'email is required';
        $token = null;

        $email = $this->request->input('email');
        if (!empty($email)) {
            $status = 'unauthorized';
            $msg = 'unauthorized email';

            $user = Users::where('email', $email)->first();
            if (!empty($user)) {
                $status = 'success';
                $msg = 'authorized email';
                $token = $this->generateToken($user->email);
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'token' => $token,
        ]);
    }

    private function generateToken($value)
    {
        return md5( (string)($this->hashKey . $value) );
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;


class UserController extends AbstractController
{
    private $requiredFields = ['token', 'email', 'user_name'];

    public function listUser()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];

        $token = $this->request->input('token');
        if (isset($token)) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($token);
            if (!! $user) {
                $status = 'success';
                $msg = 'success';
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'user' => $user,
        ]);
    }

    public function listUsers()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];
        $allUsers = [];

        $token = $this->request->input('token');
        if (isset($token)) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($token);
            if (!! $user) {
                $allUsers = $user;
                if (!! $user->superuser) {
                    $allUsers = User::all();
                }
                $status = 'success';
                $msg = 'success';
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'users' => $allUsers,
        ]);
    }

    public function createUser()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $isValid = false;
        $user = null;
        $newUser = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to create new users';

                if (!!$user->superuser) {
                    $isValid = $this->requestIsValid($data);
                    $msg = $isValid['msg'];

                    if ($isValid['valid']) {
                        $msg = 'This email is already registered';

                        if ($this->emailNotRegistered($data['email'])) {
                            $newUser = User::Create([
                                'user_name' => $data['user_name'],
                                'superuser' => (isset($data['superuser']) ? $data['superuser'] : false),
                                'email' => $data['email']
                            ]);

                            $status = 'success';
                            $msg = 'user created successfully';
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'user' => $newUser,
        ]);
    }

    public function updateUser()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $isValid = false;
        $user = null;
        $newUser = null;
        $updateUser = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to update user';

                if (!!$user->superuser) {
                    $isValid = $this->requestIsValid($data);
                    $msg = $isValid['msg'];

                    if ($isValid['valid']) {
                        $msg = 'email not found';

                        $updateUser = $this->getUser($data['email']);
                        if ($updateUser) {
                            $msg = 'Failed to update user';

                            if (empty($data['new_email'])) $data['new_email'] = $data['email'];

                            $updateUser->email = $data['new_email'];
                            $updateUser->user_name = $data['user_name'];
                            $updateUser->superuser = $data['superuser'];
                            if ($updateUser->save()) {
                                $status = 'success';
                                $msg = 'user updated successfully';
                            }

                            $newUser = $this->getUser($data['new_email']);
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'user' => $newUser,
        ]);
    }

    public function deleteUser()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $user = null;
        $userDeleted = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to create new users';

                if (!!$user->superuser) {
                    $msg = 'email not found';

                    $userDeleted = $this->getUser($data['email']);
                    if ($userDeleted) {
                        $msg = 'Failed to update user';

                        $userDeleted = User::where('id', $userDeleted->id)->delete();
                        if ($userDeleted) {
                            $status = 'success';
                            $msg = 'user deleted successfully';
                        }

                        $userDeleted = $this->getUser($data['email']);
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'user' => $userDeleted,
        ]);
    }

    private function requestIsValid($data)
    {
        $status = ['valid' => false, 'msg' => ''];

        foreach ($this->requiredFields as $value) {
            if (!isset($data[$value]) || empty($data[$value])) {
                $status['msg'] .= empty($status['msg']) ? "Fields mandatory: {$value}" : ", {$value}";
            }
        }

        $status['valid'] = !! empty($status['msg']);
        return $status;
    }

    private function emailNotRegistered($email)
    {
        return ! (User::where('email', $email)->first());
    }

    private function getUser($email)
    {
        return User::where('email', $email)->first();
    }

}

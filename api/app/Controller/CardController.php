<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Users;
use App\Model\Cards;


class CardController extends AbstractController
{
    private $requiredFields = ['token', 'user_id', 'balance'];
    private $countCards = 0;

    // TODO: verificar numero maximo de tentativas (5)
    private function getNewCardNumber() {
        $card = (string) (rand(1000000000000000, 9999999999999999));
        if (Cards::where('card_number', $card)->first() && $this->countCards++ < 5) {
            $card = $this->getNewCardNumber();
        }
        return $card;
    }

    public function listUserCards()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];
        $cards = [];

        $token = $this->request->input('token');
        if (isset($token)) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($token);
            if ($user) {
                $cards = Cards::where('fk_user', $user->id)->where('deleted', false)->get();

                $status = 'success';
                $msg = 'success';
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'cards' => $cards,
        ]);
    }

    public function listCards()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];
        $allCards = [];

        $token = $this->request->input('token');
        if (isset($token)) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($token);
            if ($user) {
                if (!! $user->superuser) {
                    $allCards = Cards::where('deleted', false)->get();
                } else {
                    $allCards = Cards::where('fk_user', $user->id)->where('deleted', false)->get();
                }
                $status = 'success';
                $msg = 'success';
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'cards' => $allCards,
        ]);
    }

    public function createCard()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $isValid = false;
        $user = null;
        $newCard = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to create new Card';

                if (!! $user->superuser) {
                    $isValid = $this->requestIsValid($data);
                    $msg = $isValid['msg'];

                    if ($isValid['valid']) {
                        $msg = 'No users with specified user_id were found';

                        if (Users::where('id', $data['user_id'])->first()) {
                            $newCardNumber = $this->getNewCardNumber();
                            $newCard = Cards::Create([
                                'fk_user' => $data['user_id'],
                                'card_number' => $newCardNumber,
                                'balance' => $data['balance']
                            ]);

                            $status = 'success';
                            $msg = 'card created successfully';
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'card' => $newCard,
        ]);
    }

    public function updateCard()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $user = null;
        $updateCard = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to update Card';

                if (!! $user->superuser) {
                    $updateCard = Cards::where('card_number', $data['card_number'])->first();
                    if ($updateCard) {
                        $msg = 'No information to update. Inform new_user_id and/or new_balance';

                        if (isset($data['new_user_id']) || isset($data['new_balance'])) {
                            $msg = 'Failed to update Card';
                            $error = false;
    
                            if (isset($data['new_user_id'])) {
                                if (! empty($data['new_user_id']) && !! Users::where('id', $data['new_user_id'])->first()) {
                                    $updateCard->fk_user = $data['new_user_id'];
                                } else {
                                    $msg = 'No users with specified user_id were found';
                                    $error = true;
                                }
                            }
    
                            if (isset($data['new_balance'])) {
                                if ((int) $data['new_balance'] >= 0) {
                                    $updateCard->balance = $data['new_balance'];
                                } else {
                                    $msg = 'the balance must be greater than or equal to zero';
                                    $error = true;
                                }
                            }
    
                            if (!$error && $updateCard->save()) {
                                $status = 'success';
                                $msg = 'Card updated successfully';
                            }
                        }

                        $updateCard = Cards::where('card_number', $data['card_number'])->first();
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'card' => $updateCard,
        ]);
    }

    public function deleteCard()
    {
        $status = 'error';
        $msg = '';
        $data = null;
        $user = null;
        $deleteCard = null;

        $data = $this->request->all();
        $msg = 'token is required';

        if (isset($data['token'])) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($data['token']);
            if ($user) {
                $msg = 'This user does not have permission to update Card';

                if (!! $user->superuser) {
                    $deleteCard = Cards::where('card_number', $data['card_number'])->first();
                    if ($deleteCard) {
                        $msg = 'Failed to update Card';

                        $deleteCard->deleted = true;
                        if ($deleteCard->save()) {
                            $status = 'success';
                            $msg = 'Card deleted successfully';
                        }

                        $deleteCard = Cards::where('card_number', $data['card_number'])->first();
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'card' => $deleteCard,
        ]);
    }

    public function listDeletedCards()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];
        $allCards = [];

        $token = $this->request->input('token');
        if (isset($token)) {
            $msg = 'Unable to find a user with the provided token';

            $user = $this->tokenService->getUserByToken($token);
            if ($user) {
                if (!! $user->superuser) {
                    $allCards = Cards::where('deleted', true)->get();
                }
                $status = 'success';
                $msg = 'success';
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'cards' => $allCards,
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
}

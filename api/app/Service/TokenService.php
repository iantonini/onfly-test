<?php

namespace App\Service;

use Hyperf\Di\Annotation\Inject;
use App\Repository\TokenRepository;

/**
 * @Component
 */
class TokenService
{
    /**
     * @Inject
     * @var TokenRepository
     */
    protected $TokenRepository;

    public function __construct(TokenRepository $TokenRepository)
    {
        $this->TokenRepository = $TokenRepository;
    }

    public function getUserByToken(string $token)
    {
        return $this->TokenRepository->findToken($token);
    }

    // public function generateToken(string $email): ?token
    // {
    //     return $this->TokenRepository->login($email);
    // }
}

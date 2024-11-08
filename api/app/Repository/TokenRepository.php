<?php

namespace App\Repository;

use Hyperf\Di\Annotation\Component;
use App\Model\Users;

/**
 * @Component
 */
class TokenRepository
{
    protected $hashKey = 'ONFLY';

    public function findToken(string $token)
    {
        return Users::whereRaw(
            'MD5(CONCAT(?, email)) = ?', 
            [ $this->hashKey, $token ]
        )->first();
    }
}

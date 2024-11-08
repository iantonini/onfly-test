<?php

declare(strict_types=1);

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Request;
use Hyperf\HttpServer\Response;

use \App\Service\TokenService;
use \App\Repository\TokenRepository;

return [
    RequestInterface::class => Request::class,
    ResponseInterface::class => Response::class,
    TokenService::class => TokenService::class,
    TokenRepository::class => TokenRepository::class,
];

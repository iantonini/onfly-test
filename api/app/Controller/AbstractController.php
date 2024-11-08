<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

use App\Service\TokenService;


abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    protected TokenService $tokenService;

    public function __construct(
        ContainerInterface $container,
        RequestInterface $request,
        ResponseInterface $response,
        TokenService $tokenService,
    ) {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
        $this->tokenService = $tokenService;
    }
}

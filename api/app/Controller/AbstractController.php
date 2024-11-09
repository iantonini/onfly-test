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
use App\Service\TransactionService;
use App\Service\ExpenseService;

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

    #[Inject]
    protected TransactionService $transactionService;

    #[Inject]
    protected ExpenseService $expenseService;


    public function __construct(
        ContainerInterface $container,
        RequestInterface $request,
        ResponseInterface $response,
        TokenService $tokenService,
        TransactionService $transactionService,
        ExpenseService $expenseService,
    ) {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
        $this->tokenService = $tokenService;
        $this->transactionService = $transactionService;
        $this->expenseService = $expenseService;
    }
}

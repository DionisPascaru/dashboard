<?php

namespace App\Http\Controllers\API\Admin\Client;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Admin\Client\ClientsSearchRequest;
use App\Services\Searcher\Clients\ClientsSearcher;
use Exception;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class ClientController
{
    /** @var ClientsSearcher $clientsSearcher */
    private ClientsSearcher $clientsSearcher;

    /** @var RestResponseFactory $restResponseFactory */
    private RestResponseFactory $restResponseFactory;

    /** @var LoggerInterface $logger */
    private LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param ClientsSearcher $clientsSearcher
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ClientsSearcher $clientsSearcher,
        RestResponseFactory $restResponseFactory,
        LoggerInterface $logger
    ) {
        $this->clientsSearcher = $clientsSearcher;
        $this->restResponseFactory = $restResponseFactory;
        $this->logger = $logger;
    }

    /**
     * Search.
     *
     * @param ClientsSearchRequest $request
     *
     * @return JsonResponse
     */
    public function search(ClientsSearchRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->ok(
                $this->clientsSearcher->search($input)
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }
}

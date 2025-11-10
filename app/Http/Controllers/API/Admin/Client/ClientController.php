<?php

namespace App\Http\Controllers\API\Admin\Client;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Admin\Client\ClientCreateRequest;
use App\Http\Requests\Admin\Client\ClientsSearchRequest;
use App\Http\Requests\Admin\Client\ClientUpdateRequest;
use App\Models\Client;
use App\Services\Searcher\Clients\ClientsSearcher;
use App\Services\Supervisors\Client\ClientSupervisor;
use Exception;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class ClientController
{
    /**
     * Constructor.
     *
     * @param ClientSupervisor $clientSupervisor
     * @param ClientsSearcher $clientsSearcher
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ClientSupervisor $clientSupervisor,
        private readonly ClientsSearcher $clientsSearcher,
        private readonly RestResponseFactory $restResponseFactory,
        private readonly LoggerInterface $logger,
    ) {
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

    /**
     * Create.
     *
     * @param ClientCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(ClientCreateRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->created(
                $this->clientSupervisor->create($input),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Update.
     *
     * @param Client $client
     * @param ClientUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(Client $client, ClientUpdateRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->ok(
                $this->clientSupervisor->update($client, $input),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Read.
     *
     * @param Client $client
     *
     * @return JsonResponse
     */
    public function read(Client $client): JsonResponse
    {
        try {
            return $this->restResponseFactory->ok(
                $this->clientSupervisor->read($client),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Delete.
     *
     * @param Client $client
     *
     * @return JsonResponse
     */
    public function delete(Client $client): JsonResponse
    {
        try {
            $this->clientSupervisor->delete($client);

            return $this->restResponseFactory->noContent();
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Read organizations.
     *
     * @param Client $client
     *
     * @return JsonResponse
     */
    public function readOrganizations(Client $client): JsonResponse
    {
        try {
            return $this->restResponseFactory->ok(
                $this->clientSupervisor->readOrganizations($client)
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }
}

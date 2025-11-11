<?php

namespace App\Http\Controllers\API\Admin\Organization;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Admin\Organization\OrganizationsSearchRequest;
use App\Services\Searcher\Organization\OrganizationsSearcher;
use Exception;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * Organization controller.
 */
class OrganizationController
{
    /**
     * Constructor.
     *
     * @param OrganizationsSearcher $organizationsSearcher
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly OrganizationsSearcher $organizationsSearcher,
        private readonly RestResponseFactory $restResponseFactory,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Search.
     *
     * @param OrganizationsSearchRequest $request
     *
     * @return JsonResponse
     */
    public function search(OrganizationsSearchRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->ok(
                $this->organizationsSearcher->search($input)
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }
}

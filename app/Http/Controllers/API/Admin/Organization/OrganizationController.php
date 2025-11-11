<?php

namespace App\Http\Controllers\API\Admin\Organization;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Admin\Organization\OrganizationCreateRequest;
use App\Http\Requests\Admin\Organization\OrganizationsSearchRequest;
use App\Http\Requests\Admin\Organization\OrganizationUpdateRequest;
use App\Models\Organization;
use App\Services\Searcher\Organization\OrganizationsSearcher;
use App\Services\Supervisors\Organization\OrganizationSupervisor;
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
     * @param OrganizationSupervisor $organizationSupervisor
     * @param OrganizationsSearcher $organizationsSearcher
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly OrganizationSupervisor $organizationSupervisor,
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

    /**
     * Create.
     *
     * @param OrganizationCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(OrganizationCreateRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->created(
                $this->organizationSupervisor->create($input),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Update.
     *
     * @param Organization $organization
     * @param OrganizationUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(Organization $organization, OrganizationUpdateRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->ok(
                $this->organizationSupervisor->update($organization, $input),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Read.
     *
     * @param Organization $organization
     *
     * @return JsonResponse
     */
    public function read(Organization $organization): JsonResponse
    {
        try {
            return $this->restResponseFactory->ok(
                $this->organizationSupervisor->read($organization),
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Delete.
     *
     * @param Organization $organization
     *
     * @return JsonResponse
     */
    public function delete(Organization $organization): JsonResponse
    {
        try {
            $this->organizationSupervisor->delete($organization);

            return $this->restResponseFactory->noContent();
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return $this->restResponseFactory->serverError($exception);
        }
    }
}

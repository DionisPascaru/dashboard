<?php

namespace App\Services\Supervisors\Organization;

use App\Enums\Organization\OrganizationFieldsEnum;
use App\Models\Organization;

/**
 * Organization supervisor.
 */
class OrganizationSupervisor
{
    /**
     * Create.
     *
     * @param array $input
     *
     * @return array
     */
    public function create(array $input): array
    {
        $organization = new Organization();
        $organization->name = $input[OrganizationFieldsEnum::NAME];
        $organization->owner_id = $input[OrganizationFieldsEnum::OWNER];
        $organization->description = $input[OrganizationFieldsEnum::DESCRIPTION] ?? null;
        $organization->email = $input[OrganizationFieldsEnum::EMAIL];
        $organization->phone = $input[OrganizationFieldsEnum::PHONE] ?? null;
        $organization->address = $input[OrganizationFieldsEnum::ADDRESS] ?? null;
        $organization->logo = $input[OrganizationFieldsEnum::LOGO] ?? null;
        $organization->save();

        return ['id' => $organization->id];
    }
}

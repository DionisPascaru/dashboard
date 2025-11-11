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

    /**
     * Update.
     *
     * @param Organization $organization
     * @param array $input
     *
     * @return array
     */
    public function update(Organization $organization, array $input): array
    {
        $organization->name = $input[OrganizationFieldsEnum::NAME];
        $organization->description = $input[OrganizationFieldsEnum::DESCRIPTION] ?? null;
        $organization->email = $input[OrganizationFieldsEnum::EMAIL];
        $organization->phone = $input[OrganizationFieldsEnum::PHONE] ?? null;
        $organization->address = $input[OrganizationFieldsEnum::ADDRESS] ?? null;
        $organization->logo = $input[OrganizationFieldsEnum::LOGO] ?? null;
        $organization->save();

        return [
            OrganizationFieldsEnum::ID => $organization->id,
            OrganizationFieldsEnum::OWNER => $organization->owner->name,
            OrganizationFieldsEnum::NAME => $organization->name,
            OrganizationFieldsEnum::DESCRIPTION => $organization->description,
            OrganizationFieldsEnum::EMAIL => $organization->email,
            OrganizationFieldsEnum::PHONE => $organization->phone,
            OrganizationFieldsEnum::ADDRESS => $organization->address,
            OrganizationFieldsEnum::LOGO => $organization->logo,
        ];
    }

    /**
     * Read.
     *
     * @param Organization $organization
     *
     * @return array
     */
    public function read(Organization $organization): array
    {
        return [
            OrganizationFieldsEnum::ID => $organization->id,
            OrganizationFieldsEnum::OWNER => $organization->owner->name,
            OrganizationFieldsEnum::NAME => $organization->name,
            OrganizationFieldsEnum::DESCRIPTION => $organization->description,
            OrganizationFieldsEnum::EMAIL => $organization->email,
            OrganizationFieldsEnum::PHONE => $organization->phone,
            OrganizationFieldsEnum::ADDRESS => $organization->address,
            OrganizationFieldsEnum::LOGO => $organization->logo,
        ];
    }

    /**
     * Delete.
     *
     * @param Organization $organization
     */
    public function delete(Organization $organization): void
    {
        $organization->delete();
    }
}

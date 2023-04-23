<?php

namespace App\Policies;
use App\Enums\PermissionType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): Response
    {
        return $this->allow();

    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ORGANIZATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Organization $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_ORGANIZATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Organization $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ORGANIZATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Organization $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ORGANIZATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function storeOrganizationType(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ORGANIZATION_TYPE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }




}

<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
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
        return $user->checkPermissionTo(PermissionType::STORE_LANGUAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Language $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_LANGUAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Language $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_LANGUAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Language $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_LANGUAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}

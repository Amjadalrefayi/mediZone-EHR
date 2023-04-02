<?php

namespace App\Http\API\V1\Controllers\User;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\User\UserRepository;
use App\Http\API\V1\Requests\User\Language\StoreUserLanguageRequest;
use App\Http\API\V1\Requests\User\Role\EditUserRoleRequest;
use App\Http\API\V1\Requests\User\StoreUserRequest;
use App\Http\API\V1\Requests\User\UpdateUserRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Users
 * APIs for user Management
 */
class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->userRepository = $userRepository;
        $this->authorizeResource(User::class);
    }

    /**
     * Show all users
     *
     * This endpoint lets you show all users
     *
     * @responseFile storage/responses/admin/users/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by name, family, suffix, prefix.
     * @queryParam filter[id] string Field to filter items by email.
     * @queryParam filter[marital_status] string Field to filter items by marital status.
     * @queryParam filter[gender] string Field to filter items by gender.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[deceased] string Field to filter items by deceased.
     * @queryParam filter[birth_date] string Field to filter items by birth_date.
     * @queryParam filter[deceased_date] string Field to filter items by deceased_date.
     * @queryParam sort string Field to sort items by id,name,family,suffix,prefix,brith_date,deceased_date,created_at.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->userRepository->index();

        return $this->showAll($paginatedData->getData(), UserResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific user
     *
     * This endpoint lets you show specific user
     *
     * @responseFile storage/responses/admin/users/show.json
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->response('success', $this->userRepository->show($user));
    }

    /**
     * Add user
     *
     * This endpoint lets you add user
     *
     * @responseFile storage/responses/admin/users/store.json
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     *
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->store($request->validated());

        return $this->showOne($user, UserResource::class, __('The user added successfully'));
    }

    /**
     * Update specific user
     *
     * This endpoint lets you update specific user
     *
     * @responseFile storage/responses/admin/users/update.json
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userRepository->update($user, $request->validated());

        return $this->showOne($updatedUser, UserResource::class, __("User's information updated successfully"));
    }

    /**
     * Delete specific user
     *
     * This endpoint lets you user specific user
     *
     * @responseFile storage/responses/admin/users/delete.json
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->delete($user);
        return $this->responseMessage(__('The user deleted successfully'));
    }

    /**
     * Show all roles to specific user
     *
     * This endpoint lets you show all roles to specific user
     *
     * @responseFile storage/responses/admin/users/roles/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter string Field to filter items by id,name,description.
     * @queryParam sort string Field to sort items by id,name,description.
     *
     * @param User $user
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function indexRoles(User $user): JsonResponse
    {
        $this->authorize('viewAnyUserRoles', $user);
        $paginatedData = $this->userRepository->indexRoles($user);

        return $this->showAll($paginatedData->getData(), RoleResource::class, $paginatedData->getPagination());
    }

    /**
     * Edit user's roles
     *
     * This endpoint lets you edit user's roles (add,update,delete)
     *
     * @responseFile storage/responses/admin/users/roles/store.json
     *
     * @param EditUserRoleRequest $request
     * @param User $user
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function storeRoles(EditUserRoleRequest $request, User $user): JsonResponse
    {
        $this->authorize('createUserRoles', $user);
        $this->userRepository->editRoles($request->validated()['role_ids'], $user);

        return $this->responseMessage(__("The user's roles updated successfully."));
    }


    /**
     * Add user language
     *
     * This endpoint lets you add user language
     *
     * @responseFile storage/responses/admin/users/languages/store.json
     *
     * @param StoreUserLanguageRequest $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function storeUserLanguage(StoreUserLanguageRequest $request): JsonResponse
    {
        $this->authorize('storeUserLanguage', Auth::user());
        $data = collect($request->validated());
        $this->userRepository->storeUserLanguage($data);

        return $this->responseMessage(__("The user language added successfully."));
    }

}

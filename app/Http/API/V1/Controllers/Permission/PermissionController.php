<?php

namespace App\Http\API\V1\Controllers\Permission;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Permission\PermissionRepository;
use App\Http\Resources\Permission\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;

/**
 * @group Permissions
 * APIs for getting permissions
 */
class PermissionController extends Controller
{
    protected PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->permissionRepository = $permissionRepository;
        $this->authorizeResource(Permission::class);

    }

    /**
     * Show All
     *
     * This endpoint lets you show all permissions
     *
     * @responseFile storage/responses/admin/permissions/index.json
     *
     * @queryParam filter[search] string Field to filter items by all fields, name, description.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->permissionRepository->index();

        return $this->showAll($paginatedData->getData(), PermissionResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific permission
     *
     * This endpoint lets you show specific permission
     *
     * @responseFile storage/responses/admin/permissions/show.json
     *
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
        return $this->showOne($this->permissionRepository->show($permission), PermissionResource::class);
    }
}

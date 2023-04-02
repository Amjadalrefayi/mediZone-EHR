<?php

namespace Tests\API\V1\Controllers\User;

use App\Enums\PermissionType;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class DeleteTest extends V1TestCase
{
    public function test_delete_user_by_id_by_user_unauthorized()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('admin/users/' . $user->id);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_delete_user_by_id_by_user_not_has_permission()
    {
        $user = User::factory()->create();
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->deleteJson('admin/users/' . $user->id);
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_delete_user_by_id_by_user_has_permission()
    {
        $user = User::factory()->create();
        $userLogin = $this->getUserHasPermission(PermissionType::DELETE_USER);
        Sanctum::actingAs($userLogin);
        $response = $this->deleteJson('admin/users/' . $user->id);
        $response->assertStatus(200)
            ->assertJson([
                'message' => __('The user deleted successfully'),
                'status_code' => 200,
            ]);
        $this->assertCount(1, User::onlyTrashed()->get());
        $this->saveResponseToFile($response, 'admin/users/delete.json');
    }

}

<?php

namespace V1\Controllers\User;

use App\Enums\PermissionType;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class ShowTest extends V1TestCase
{
    private const json_structure = [
        'data' => [
                'id',
                'id_number',
                'name',
                'family',
                'prefix',
                'suffix',
                'marital_status',
                'gender',
                'type',
                'photo',
                'deceased',
                'birth_date',
                'deceased_date',
        ],
    ];

    public function test_get_user_by_id_by_user_unauthorized()
    {
        $user = User::factory()->create();
        $response = $this->getJson('admin/users/' . $user->id);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_get_user_by_id_by_user_not_has_permission()
    {
        $user = User::factory()->create();
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->getJson('admin/users/' . $user->id);
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_get_user_by_id_by_user_has_permission_show()
    {
        $user = User::factory()->create();
        $admin = $this->getUserHasPermission(PermissionType::SHOW_USER);
        Sanctum::actingAs($admin);
        $response = $this->getJson('admin/users/' . $user->id);
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $this->saveResponseToFile($response, 'admin/users/show.json');
    }

}

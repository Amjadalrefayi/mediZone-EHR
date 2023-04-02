<?php

namespace Tests\API\V1\Controllers\Language;

use App\Enums\PermissionType;
use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class ShowTest extends V1TestCase
{
    private const json_structure = [
        'data' => [
            'id',
            'code',
            'name',
        ],
    ];

    public function test_get_language_by_id_by_user_unauthorized()
    {
        $user = User::factory()->create();
        $response = $this->getJson('admin/languages/' . $user->id);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_get_language_by_id_by_user_not_has_permission()
    {
        $language = Language::factory()->create();
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->getJson('admin/languages/' . $language->id);
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_get_user_by_id_by_user_has_permission_show()
    {
        $language = Language::factory()->create();
        $admin = $this->getUserHasPermission(PermissionType::SHOW_LANGUAGE);
        Sanctum::actingAs($admin);
        $response = $this->getJson('admin/languages/' . $language->id);
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $this->saveResponseToFile($response, 'admin/languages/show.json');
    }
}

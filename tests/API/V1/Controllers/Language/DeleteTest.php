<?php

namespace Tests\API\V1\Controllers\Language;

use App\Enums\PermissionType;
use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class DeleteTest extends V1TestCase
{
    public function test_delete_language_by_id_by_user_unauthorized()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('admin/languages/' . $user->id);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_delete_language_by_id_by_user_not_has_permission()
    {
        $language = Language::factory()->create();
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->deleteJson('admin/languages/' . $language->id);
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_language_user_by_id_by_user_has_permission()
    {
        $language = Language::factory()->create();
        $userLogin = $this->getUserHasPermission(PermissionType::DELETE_LANGUAGE);
        Sanctum::actingAs($userLogin);
        $response = $this->deleteJson('admin/languages/' . $language->id);
        $response->assertStatus(200)
            ->assertJson([
                'message' => __('Language deleted successfully'),
                'status_code' => 200,
            ]);
        $this->assertCount(1, Language::onlyTrashed()->get());
        $this->saveResponseToFile($response, 'admin/languages/delete.json');
    }
}

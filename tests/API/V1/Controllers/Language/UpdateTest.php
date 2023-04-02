<?php

namespace Tests\API\V1\Controllers\Language;

use App\Enums\PermissionType;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class UpdateTest extends V1TestCase
{
    public function test_update_language_by_id_by_user_unauthorized()
    {
        $language = Language::factory()->create();
        $response = $this->putJson('admin/languages/' . $language->id);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_update_language_by_id_by_user_not_has_permission_update()
    {
        $language = Language::factory()->create();
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->putJson('admin/languages/' . $language->id);
        $response->assertStatus(403)
            ->assertJson(['message' => __('auth.permission_required'), 'status_code' => 403]);
    }

    public function test_update_language_by_user_has_permission_update()
    {
        $language = Language::factory()->create();
        $userLogin = $this->getDashboardUserHasPermission(PermissionType::UPDATE_LANGUAGE);
        Sanctum::actingAs($userLogin);
        $response = $this->putJson('admin/languages/' . $language->id, [
            'name' => 'TESTER',
            'code' => 'ar',
        ]);
        $language->refresh();
        $response->assertStatus(200)
            ->assertJsonFragment($this->dataResponse($language, LanguageResource::class));
        $this->assertSame('TESTER', $language->name);
        $this->assertSame('ar', $language->code);
        $this->saveResponseToFile($response, 'admin/languages/update.json');
    }

}

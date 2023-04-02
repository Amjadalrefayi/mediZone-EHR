<?php

namespace Tests\API\V1\Controllers\Language;

use App\Enums\PermissionType;
use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class StoreTest extends V1TestCase
{
    public function test_add_language_by_user_not_authorized()
    {
        $response = $this->postJson('admin/languages',
            [
                'name' => 'title',
                'code' => 'AE',
            ]);
        $this->assertCount(0, Language::all());
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_add_language_by_user_has_not_permission()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->postJson('admin/languages',
            [
                'name' => 'name',
                'code' => 'AE',
            ]);
        $this->assertCount(0, Language::all());
        $response->assertStatus(403)
            ->assertJson(['message' => __('auth.permission_required'), 'status_code' => 403]);
    }

    public function test_add_language_by_user_has_permission_store()
    {
        $user = $this->getUserHasPermission(PermissionType::STORE_LANGUAGE);
        Sanctum::actingAs($user, ['']);
        $response = $this->postJson('admin/languages', [
            'name' => 'name',
            'code' => 'AE',
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'The language added successfully', 'status_code' => 200]);
        $this->assertCount(1, Language::all());

        $this->saveResponseToFile($response, 'admin/languages/store.json');
    }

    public function test_add_language_field_required()
    {
        $user = $this->getUserHasPermission(PermissionType::STORE_LANGUAGE);
        Sanctum::actingAs($user, ['']);
        $response = $this->postJson('admin/languages', [
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'data' => [
                    'name' => ['The name field is required.'],
                    'code' => ['The code field is required.'],
                ],
                'status_code' => '422',
            ]);
    }
}

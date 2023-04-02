<?php

namespace Tests\API\V1\Controllers\User\Language;

use App\Enums\PermissionType;
use App\Models\Language;
use App\Models\User;
use App\Models\UserLanguages;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class StoreTest extends V1TestCase
{
    public function test_add_user_language_by_user_unauthorized()
    {
        $response = $this->postJson('admin/users/language',[
            'user_id' => User::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
            'preferred' => true,
        ]);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_add_user_language_by_user_not_has_permission()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson('admin/users/language',[
            'user_id' => User::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
            'preferred' => true,
        ]);
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_add_user_language_by_user_has_permission()
    {
        $user = $this->getUserHasPermission(PermissionType::STORE_USER_LANGUAGE);
        Sanctum::actingAs($user);
        $response = $this->postJson('admin/users/language',[
            'user_id' => User::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
            'preferred' => true,
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => __('The user language added successfully.'),
                'status_code' => 200,
            ]);
        $this->assertCount(1, UserLanguages::all());
        $this->saveResponseToFile($response, 'admin/users/languages/store.json');
    }

}

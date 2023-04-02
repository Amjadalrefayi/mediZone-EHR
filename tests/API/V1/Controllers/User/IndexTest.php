<?php

namespace Tests\API\V1\Controllers\User;

use App\Enums\PermissionType;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class IndexTest extends V1TestCase
{
    private const json_structure = [
        'data' => [
            '*' => [
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
        ],
    ];
    public function test_get_all_users_by_user_unauthorized()
    {
        $response = $this->getJson('admin/users');
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_get_all_users_by_user_not_has_permission()
    {
        $userLogin = User::factory()->create();
        Sanctum::actingAs($userLogin);
        $response = $this->getJson('admin/users');
        $response->assertStatus(403)
            ->assertJson([
                'message' => __('auth.permission_required'),
                'status_code' => 403,
            ]);
    }

    public function test_get_all_users_by_admin_has_permission()
    {
        User::factory()->count(15)->create();
        $user = $this->getUserHasPermission(PermissionType::INDEX_USER);
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/users?page=2&per_page=5');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $response->assertJsonCount(5, 'data');
        $response->assertJson($this->dataResponsePagination(16));
        $this->saveResponseToFile($response, 'admin/users/index.json');
    }

    public function test_get_all_users_filter_by_id()
    {
        User::factory()->create([
            'id' => 555,
        ]);
        User::factory()->create([
            'id' => 1111111,
        ]);
        User::factory()->create([
            'id' => 11111111,
        ]);
        $user = $this->getUserHasPermission(PermissionType::INDEX_USER, [
            'id' => 666,
        ]);
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/users?filter[id]=1111111');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure)
            ->assertJsonCount(1, 'data');
    }

    public function test_get_all_users_filter_by_search()
    {
        User::factory()->create([
            'name' => 'test',
        ]);
        User::factory()->create([
            'family' => 'test',
        ]);
        User::factory()->create([
            'suffix' => 'test',
        ]);
        User::factory()->create([
            'prefix' => 'test',
        ]);
        User::factory()->create([
            'name' => 'amjad',
        ]);
        $admin = $this->getUserHasPermission(PermissionType::INDEX_USER);
        Sanctum::actingAs($admin, ['']);
        $response = $this->getJson('admin/users?filter[search]=test');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure)
            ->assertJsonCount(4, 'data');
    }

    public function test_get_all_users_filter_by_birth_date()
    {
        User::factory()->create([
            'birth_date' => '2020-10-10',
        ]);
        User::factory()->create([
            'birth_date' => '2020-10-10',
        ]);
        User::factory()->create([
            'birth_date' => '2020-11-10',
        ]);
        User::factory()->create([
            'birth_date' => '2020-11-01',
        ]);
        User::factory()->create([
            'birth_date' => '2023-01-01',
        ]);
        $admin = $this->getUserHasPermission(PermissionType::INDEX_USER);
        Sanctum::actingAs($admin, ['']);
        $response = $this->getJson('admin/users?filter[birth_date]=2020-10-01,2020-11-01');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_all_users_sort_by_id_ascending()
    {
        User::factory()->count(10)->create();
        $user = $this->getUserHasPermission(PermissionType::INDEX_USER);
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/users?sort=id');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $user = User::orderBy('id')->first();
        $content = json_decode($response->getContent());
        $this->assertEquals($user->id, $content->data[0]->id);
    }

    public function test_get_all_users_sort_by_id_descending()
    {
        User::factory()->count(10)->create();
        $user = $this->getUserHasPermission(PermissionType::INDEX_USER);
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/users?sort=-id');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $user = User::orderByDesc('id')->first();
        $content = json_decode($response->getContent());
        $this->assertEquals($user->id, $content->data[0]->id);
    }

    private function dataResponsePagination($total)
    {
        return
            ['meta' => ['pagination' => [
                'total' => $total,
                'count' => 5,
                'per_page' => 5,
                'current_page' => 2,
            ],
            ]];
    }

}

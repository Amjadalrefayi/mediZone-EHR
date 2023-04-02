<?php

namespace Tests\API\V1\Controllers\Language;

use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class IndexTest extends V1TestCase
{
    private const json_structure = [
        'data' => [
            '*' =>[
                'id',
                'name',
                'code',
            ]
        ],
    ];

    public function test_get_all_languages_by_user_unauthorized()
    {
        $response = $this->getJson('admin/languages');
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized', 'status_code' => 401]);
    }

    public function test_get_all_languages_by_admin_has_permission()
    {
        Language::factory()->count(15)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/languages?page=2&per_page=5');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $response->assertJsonCount(5, 'data');
        $response->assertJson($this->dataResponsePagination(15));
        $this->saveResponseToFile($response, 'admin/languages/index.json');
    }

    public function test_get_all_languages_filter_by_id()
    {
        Language::factory()->create([
            'id' => 555,
        ]);
        Language::factory()->create([
            'id' => 1111111,
        ]);
        Language::factory()->create([
            'id' => 11111111,
        ]);
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/languages?filter[id]=1111111');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure)
            ->assertJsonCount(1, 'data');
    }

    public function test_get_all_languages_filter_search()
    {
        Language::factory()->create([
            'code' => 'ar',
        ]);
        Language::factory()->create([
            'name' => 'ar',
        ]);
        Language::factory()->create([
            'name' => 'test',
        ]);
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/languages?filter[search]=ar');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure)
            ->assertJsonCount(2, 'data');
    }

    public function test_get_all_languages_sort_by_id_ascending()
    {
        Language::factory()->count(10)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/languages?sort=id');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $lang = Language::orderBy('id')->first();
        $content = json_decode($response->getContent());
        $this->assertEquals($lang->id, $content->data[0]->id);
    }

    public function test_get_all_languages_sort_by_id_descending()
    {
        Language::factory()->count(10)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['']);
        $response = $this->getJson('admin/languages?sort=-id');
        $response->assertStatus(200)->assertJsonStructure(self::json_structure);
        $lang = Language::orderByDesc('id')->first();
        $content = json_decode($response->getContent());
        $this->assertEquals($lang->id, $content->data[0]->id);
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

<?php

namespace Tests\API\V1;


use App\Traits\ApiResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helper;
use Tests\TestCase;

abstract class V1TestCase extends TestCase
{
    use  Helper, WithFaker, ApiResponse;

    protected function setUp(): void
    {
        parent::setUp();
        // set your headers here
        $this->withHeaders([
            'App-Secret' => config('mediZone.auth.v1.web.secret'),
            'Platform' => 'web',
        ]);
    }

    protected function prepareUrlForRequest($uri): string
    {
        return 'api/v1/' . $uri;
    }
}

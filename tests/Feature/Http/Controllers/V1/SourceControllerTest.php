<?php

namespace Tests\Feature\Http\Controllers\V1;


use App\Models\Source\Source;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SourceControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_retrieve_sources(): void
    {
        $sources = Source::factory()->create();

        $response = $this->getJson(route('v1.sources.paginate'));

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [0 => ['name' => $sources->name]]
            ]);

    }
}

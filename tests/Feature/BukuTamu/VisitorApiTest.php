<?php

namespace Tests\Feature\BukuTamu;

use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VisitorApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_public_can_register_visitor_with_base64_photo(): void
    {
        // 1x1 transparent PNG base64
        $base64Photo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'asal_daerah' => 'Kabupaten Madiun',
            'purpose' => 'aplikasi_informatika',
            'notes' => 'Konsultasi integrasi sistem web OPD',
            'latitude' => -7.6298,
            'longitude' => 111.5239,
            'photo' => $base64Photo,
        ];

        $response = $this->postJson('/api/visitors', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Visitor registered successfully',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'asal_daerah',
                    'purpose',
                    'notes',
                    'photo_path',
                    'photo_url',
                    'visit_date',
                ],
            ]);

        $this->assertDatabaseHas('visitors', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'asal_daerah' => 'Kabupaten Madiun',
            'purpose' => 'aplikasi_informatika',
        ]);

        $visitor = Visitor::first();
        $this->assertNotNull($visitor->photo_path);
        Storage::disk('public')->assertExists($visitor->photo_path);
    }

    public function test_registration_fails_when_required_fields_are_missing(): void
    {
        $response = $this->postJson('/api/visitors', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation error',
            ])
            ->assertJsonValidationErrors(['name', 'phone', 'asal_daerah', 'purpose', 'photo']);
    }

    public function test_registration_fails_with_invalid_purpose(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'asal_daerah' => 'Madiun',
            'purpose' => 'invalid_purpose_value',
            'photo' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
        ];

        $response = $this->postJson('/api/visitors', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['purpose']);
    }

    public function test_can_get_paginated_visitors(): void
    {
        Visitor::factory()->count(15)->create();

        $response = $this->getJson('/api/visitors');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'purpose',
                            'asal_daerah',
                            'photo_url',
                        ],
                    ],
                    'total',
                ],
            ]);

        $this->assertEquals(15, $response->json('data.total'));
        $this->assertCount(10, $response->json('data.data'));
    }

    public function test_can_filter_visitors_by_purpose_and_name(): void
    {
        Visitor::factory()->create([
            'name' => 'Fajar Pratama',
            'purpose' => 'statistik',
        ]);

        Visitor::factory()->create([
            'name' => 'Dewi Lestari',
            'purpose' => 'sekretariat',
        ]);

        // Filter by purpose
        $responsePurpose = $this->getJson('/api/visitors?purpose=statistik');
        $responsePurpose->assertStatus(200);
        $this->assertEquals(1, $responsePurpose->json('data.total'));
        $this->assertEquals('Fajar Pratama', $responsePurpose->json('data.data.0.name'));

        // Search by name
        $responseName = $this->getJson('/api/visitors?name=Dewi');
        $responseName->assertStatus(200);
        $this->assertEquals(1, $responseName->json('data.total'));
        $this->assertEquals('Dewi Lestari', $responseName->json('data.data.0.name'));
    }

    public function test_can_get_single_visitor_detail(): void
    {
        $visitor = Visitor::factory()->create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
        ]);

        $response = $this->getJson("/api/visitors/{$visitor->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $visitor->id,
                    'name' => 'Ahmad Dahlan',
                    'email' => 'ahmad@example.com',
                ],
            ]);
    }

    public function test_get_non_existent_visitor_returns_404(): void
    {
        $response = $this->getJson('/api/visitors/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Visitor not found',
            ]);
    }

    public function test_can_update_visitor_data(): void
    {
        $visitor = Visitor::factory()->create([
            'name' => 'Old Name',
            'purpose' => 'sekretariat',
        ]);

        $response = $this->putJson("/api/visitors/{$visitor->id}", [
            'name' => 'Updated Name',
            'purpose' => 'aplikasi_informatika',
            'notes' => 'Updated notes',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Visitor updated successfully',
                'data' => [
                    'id' => $visitor->id,
                    'name' => 'Updated Name',
                    'purpose' => 'aplikasi_informatika',
                ],
            ]);

        $this->assertDatabaseHas('visitors', [
            'id' => $visitor->id,
            'name' => 'Updated Name',
            'purpose' => 'aplikasi_informatika',
        ]);
    }

    public function test_can_delete_visitor_and_its_photo(): void
    {
        $photoPath = 'photos/' . date('Y/m/') . 'test_photo.jpg';
        Storage::disk('public')->put($photoPath, 'dummy photo content');

        $visitor = Visitor::factory()->create([
            'photo_path' => $photoPath,
        ]);

        $response = $this->deleteJson("/api/visitors/{$visitor->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Visitor deleted successfully',
            ]);

        $this->assertDatabaseMissing('visitors', ['id' => $visitor->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_can_get_visitor_statistics(): void
    {
        Visitor::factory()->count(3)->create([
            'purpose' => 'sekretariat',
            'visit_date' => now(),
        ]);
        Visitor::factory()->count(2)->create([
            'purpose' => 'aplikasi_informatika',
            'visit_date' => now(),
        ]);

        $response = $this->getJson('/api/statistics');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total',
                    'today',
                    'this_month',
                    'purpose_stats',
                    'monthly_stats',
                ],
            ]);

        $this->assertEquals(5, $response->json('data.total'));
        $this->assertEquals(5, $response->json('data.today'));
        $this->assertEquals(5, $response->json('data.this_month'));
    }

    public function test_can_export_visitors_to_pdf(): void
    {
        Visitor::factory()->count(5)->create();

        $response = $this->get('/api/export/pdf?format=a4&orientation=portrait');

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-type'), 'application/pdf') ||
            str_contains($response->headers->get('content-disposition'), 'inline')
        );
    }
}

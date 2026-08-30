<?php

namespace Tests\Unit\Models;

use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_be_created_with_fillable_attributes(): void
    {
        $visitor = Visitor::create([
            'name' => 'Budi Pratama',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'asal_daerah' => 'Kabupaten Madiun',
            'purpose' => 'aplikasi_informatika',
            'notes' => 'Konsultasi integrasi sistem',
            'photo_path' => 'photos/test_visitor.jpg',
            'visit_date' => now(),
        ]);

        $this->assertInstanceOf(Visitor::class, $visitor);
        $this->assertEquals('Budi Pratama', $visitor->name);
        $this->assertEquals('budi@example.com', $visitor->email);
        $this->assertEquals('081234567890', $visitor->phone);
        $this->assertEquals('Kabupaten Madiun', $visitor->asal_daerah);
        $this->assertEquals('aplikasi_informatika', $visitor->purpose);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $visitor->visit_date);
    }

    public function test_photo_url_accessor_handles_relative_path_and_external_url(): void
    {
        $localVisitor = new Visitor(['photo_path' => 'visitors/photo.jpg']);
        $this->assertStringContainsString('storage/visitors/photo.jpg', $localVisitor->photo_url);

        $externalVisitor = new Visitor(['photo_path' => 'https://images.example.com/photo.jpg']);
        $this->assertEquals('https://images.example.com/photo.jpg', $externalVisitor->photo_url);

        $emptyVisitor = new Visitor(['photo_path' => null]);
        $this->assertNull($emptyVisitor->photo_url);
    }

    public function test_visitor_purpose_constants_contain_official_departments(): void
    {
        $options = Visitor::PURPOSE_OPTIONS;

        $this->assertArrayHasKey('sekretariat', $options);
        $this->assertArrayHasKey('aplikasi_informatika', $options);
        $this->assertArrayHasKey('persandian_keamanan_informasi', $options);
        $this->assertArrayHasKey('informasi_komunikasi_publik', $options);
        $this->assertArrayHasKey('statistik', $options);
    }
}

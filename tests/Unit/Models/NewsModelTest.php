<?php

namespace Tests\Unit\Models;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_can_be_created_with_fillable_attributes(): void
    {
        $news = News::create([
            'title' => 'M-GEN Sukses Gelar Turnamen Esports Pemuda',
            'content' => 'Ratusan peserta antusias mengikuti kompetisi game kompetitif.',
            'category' => 'Tournament Info',
            'image' => 'news/cover.jpg',
        ]);

        $this->assertInstanceOf(News::class, $news);
        $this->assertEquals('M-GEN Sukses Gelar Turnamen Esports Pemuda', $news->title);
        $this->assertEquals('Tournament Info', $news->category);
    }

    public function test_news_image_url_accessor(): void
    {
        $localNews = new News(['image' => 'news/article.jpg']);
        $this->assertStringContainsString('storage/news/article.jpg', $localNews->image_url);

        $externalNews = new News(['image' => 'https://example.com/news.jpg']);
        $this->assertEquals('https://example.com/news.jpg', $externalNews->image_url);

        $nullNews = new News(['image' => null]);
        $this->assertNull($nullNews->image_url);
    }

    public function test_news_filter_scope(): void
    {
        $news1 = News::create([
            'title' => 'Tips Strategi Bermain Game',
            'content' => 'Panduan taktik permainan',
            'category' => 'Esport News',
        ]);

        $news2 = News::create([
            'title' => 'Pengumuman Pemenang M-GEN',
            'content' => 'Daftar juara turnamen',
            'category' => 'Pengumuman',
        ]);

        $filteredCategory = News::filter(['category' => 'Pengumuman'])->get();
        $this->assertTrue($filteredCategory->contains($news2));
        $this->assertFalse($filteredCategory->contains($news1));

        $filteredSearch = News::filter(['q' => 'Strategi'])->get();
        $this->assertTrue($filteredSearch->contains($news1));
        $this->assertFalse($filteredSearch->contains($news2));
    }
}

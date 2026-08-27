<?php

namespace Tests\Feature\Esport\Admin;

use App\Models\Admin;
use App\Models\News;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsAndTournamentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $esportAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->esportAdmin = Admin::factory()->esport()->create();
    }

    /**
     * Test admin can view news list.
     */
    public function test_admin_can_view_news_list(): void
    {
        $news = News::factory()->create(['title' => 'Turnamen Mobile Legends 2026']);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.news.index'));

        $response->assertStatus(200);
        $response->assertSee('Turnamen Mobile Legends 2026');
        $response->assertSee('News Management');
    }

    /**
     * Test admin can view news create form.
     */
    public function test_admin_can_view_news_create_form(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.news.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Article');
    }

    /**
     * Test admin can view news edit form.
     */
    public function test_admin_can_view_news_edit_form(): void
    {
        $news = News::factory()->create(['title' => 'Berita Lama']);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.news.edit', $news));

        $response->assertStatus(200);
        $response->assertSee('Edit Article');
        $response->assertSee('Berita Lama');
    }

    /**
     * Test admin can view tournaments list.
     */
    public function test_admin_can_view_tournaments_list(): void
    {
        $tournament = Tournament::factory()->create([
            'title' => 'Madiun Cup Season 1',
            'game' => 'mobile_legends',
            'status' => 'upcoming',
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.tournaments.index'));

        $response->assertStatus(200);
        $response->assertSee('Madiun Cup Season 1');
        $response->assertSee('Tournaments');
    }

    /**
     * Test admin can view tournament create form.
     */
    public function test_admin_can_view_tournament_create_form(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.tournaments.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Tournament');
    }

    /**
     * Test admin can view tournament edit form.
     */
    public function test_admin_can_view_tournament_edit_form(): void
    {
        $tournament = Tournament::factory()->create([
            'title' => 'Valorant Championship',
            'game' => 'valorant',
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.tournaments.edit', $tournament));

        $response->assertStatus(200);
        $response->assertSee('Edit Tournament');
        $response->assertSee('Valorant Championship');
    }
}

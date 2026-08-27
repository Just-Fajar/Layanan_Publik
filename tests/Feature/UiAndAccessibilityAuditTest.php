<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UiAndAccessibilityAuditTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->superAdmin()->create();
    }

    /**
     * Test esport about page renders logo and status 200.
     */
    public function test_esport_about_page_renders_cleanly(): void
    {
        $response = $this->get(route('esport.about'));

        $response->assertStatus(200);
        $response->assertSee('images/logo-mgen.png');
        $response->assertDontSee('illustration-esport.png');
    }

    /**
     * Test admin user management renders username with @ symbol without raw blade tags.
     */
    public function test_admin_user_views_render_username_without_raw_blade_escapes(): void
    {
        $user = User::factory()->create([
            'name' => 'Fajar Tester',
            'username' => 'fajar_tester',
        ]);

        $responseIndex = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.users.index'));

        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('@fajar_tester');
        $responseIndex->assertDontSee('@{{');

        $responseShow = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.users.show', $user));

        $responseShow->assertStatus(200);
        $responseShow->assertSee('@fajar_tester');
        $responseShow->assertDontSee('@{{');
    }

    /**
     * Test calendar event create form contains accessible labels and inputs with matching IDs.
     */
    public function test_event_create_and_edit_forms_have_accessible_labels(): void
    {
        $event = Event::factory()->create();

        $responseCreate = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.events.create'));

        $responseCreate->assertStatus(200);
        $responseCreate->assertSee('for="title"', false);
        $responseCreate->assertSee('id="title"', false);
        $responseCreate->assertSee('for="category"', false);
        $responseCreate->assertSee('id="category"', false);

        $responseEdit = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.events.edit', $event));

        $responseEdit->assertStatus(200);
        $responseEdit->assertSee('for="title"', false);
        $responseEdit->assertSee('id="title"', false);
    }
}

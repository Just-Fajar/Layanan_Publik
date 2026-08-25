<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('homepage.homepage');
    }

    public function test_homepage_contains_all_module_links_and_portal_access(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Check module links
        $response->assertSee(route('buku-tamu'));
        $response->assertSee(route('calendar.index'));
        $response->assertSee(route('esport.home'));

        // Check login portal links
        $response->assertSee(route('admin.login'));
        $response->assertSee(route('calendar.auth.login'));
        $response->assertSee(route('esport.auth.login'));
    }
}

<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected Admin $bukuTamuAdmin;

    protected Admin $esportAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = Admin::factory()->superAdmin()->create();
        $this->bukuTamuAdmin = Admin::factory()->bukuTamu()->create();
        $this->esportAdmin = Admin::factory()->esport()->create();
    }

    /**
     * Grey-Box Test: Unauthenticated access to Buku Tamu admin redirects to login.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/buku-tamu/admin/dashboard');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Grey-Box Test: Unauthenticated access to Esport admin redirects to login.
     */
    public function test_guest_is_redirected_when_accessing_esport_admin(): void
    {
        $response = $this->get('/buku-tamu/admin/esport/tournaments');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Grey-Box Test: Buku Tamu Admin can access Buku Tamu dashboard.
     */
    public function test_buku_tamu_admin_can_access_buku_tamu_dashboard(): void
    {
        $response = $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Grey-Box Test: Buku Tamu Admin cannot access Esport admin panel (403).
     */
    public function test_buku_tamu_admin_cannot_access_esport_admin_panel(): void
    {
        $response = $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/esport/tournaments');

        $response->assertStatus(403);
    }

    /**
     * Grey-Box Test: Esport Admin can access Esport admin panel.
     */
    public function test_esport_admin_can_access_esport_admin_panel(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get('/buku-tamu/admin/esport/tournaments');

        $response->assertStatus(200);
    }

    /**
     * Grey-Box Test: Esport Admin cannot access Buku Tamu dashboard (403).
     */
    public function test_esport_admin_cannot_access_buku_tamu_dashboard(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get('/buku-tamu/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Grey-Box Test: Super Admin can access all modules.
     */
    public function test_super_admin_can_access_all_admin_modules(): void
    {
        $bukuTamuResponse = $this->actingAs($this->superAdmin, 'admin')
            ->get('/buku-tamu/admin/dashboard');
        $bukuTamuResponse->assertStatus(200);

        $esportResponse = $this->actingAs($this->superAdmin, 'admin')
            ->get('/buku-tamu/admin/esport/tournaments');
        $esportResponse->assertStatus(200);
    }
}

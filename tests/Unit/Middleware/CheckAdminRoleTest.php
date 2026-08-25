<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\CheckAdminRole;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CheckAdminRoleTest extends TestCase
{
    protected CheckAdminRole $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CheckAdminRole;
    }

    /**
     * White-Box Test: Unauthenticated web request redirects to login.
     */
    public function test_unauthenticated_web_request_redirects_to_login(): void
    {
        Auth::shouldReceive('guard->check')->once()->andReturn(false);

        $request = Request::create('/buku-tamu/admin/dashboard', 'GET');
        $response = $this->middleware->handle($request, function () {});

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.login'), $response->getTargetUrl());
    }

    /**
     * White-Box Test: Unauthenticated JSON request returns 401.
     */
    public function test_unauthenticated_json_request_returns_401(): void
    {
        Auth::shouldReceive('guard->check')->once()->andReturn(false);

        $request = Request::create('/buku-tamu/admin/dashboard', 'GET', [], [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);
        $response = $this->middleware->handle($request, function () {});

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->getStatusCode());
    }

    /**
     * White-Box Test: Authenticated admin with no role restriction is allowed.
     */
    public function test_authenticated_admin_with_no_role_restriction_passes(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/buku-tamu/admin/dashboard', 'GET');
        $passed = false;

        $this->middleware->handle($request, function () use (&$passed) {
            $passed = true;

            return response('OK');
        });

        $this->assertTrue($passed);
    }

    /**
     * White-Box Test: Super admin can access any module.
     */
    public function test_super_admin_can_access_any_module(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/buku-tamu/admin/esport/tournaments', 'GET');
        $passed = false;

        $this->middleware->handle($request, function () use (&$passed) {
            $passed = true;

            return response('OK');
        }, 'module', 'esport');

        $this->assertTrue($passed);
    }

    /**
     * White-Box Test: Buku Tamu admin accessing esport module throws 403.
     */
    public function test_buku_tamu_admin_accessing_esport_module_is_forbidden(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/buku-tamu/admin/esport/tournaments', 'GET');

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Akses ditolak. Anda tidak memiliki izin untuk mengakses modul esport.');

        $this->middleware->handle($request, function () {}, 'module', 'esport');
    }

    /**
     * White-Box Test: Esport admin accessing esport module passes.
     */
    public function test_esport_admin_accessing_esport_module_passes(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_ESPORT]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/buku-tamu/admin/esport/tournaments', 'GET');
        $passed = false;

        $this->middleware->handle($request, function () use (&$passed) {
            $passed = true;

            return response('OK');
        }, 'module', 'esport');

        $this->assertTrue($passed);
    }

    /**
     * White-Box Test: Explicit role matching allows allowed roles and blocks forbidden ones.
     */
    public function test_explicit_roles_allow_matching_roles(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_ESPORT]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/admin/custom', 'GET');
        $passed = false;

        $this->middleware->handle($request, function () use (&$passed) {
            $passed = true;

            return response('OK');
        }, 'admin_buku_tamu', 'admin_esport');

        $this->assertTrue($passed);
    }

    /**
     * White-Box Test: JSON request when forbidden returns 403 JSON response.
     */
    public function test_forbidden_json_request_returns_403_json(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        Auth::shouldReceive('guard->check')->once()->andReturn(true);
        Auth::shouldReceive('guard->user')->once()->andReturn($admin);

        $request = Request::create('/buku-tamu/admin/esport/tournaments', 'GET', [], [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $response = $this->middleware->handle($request, function () {}, 'module', 'esport');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }
}

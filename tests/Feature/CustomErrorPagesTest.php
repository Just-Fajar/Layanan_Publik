<?php

namespace Tests\Feature;

use Tests\TestCase;

class CustomErrorPagesTest extends TestCase
{
    public function test_404_error_view_exists_and_contains_expected_content(): void
    {
        $view = $this->view('errors.404');

        $view->assertSee('404');
        $view->assertSee('Halaman Tidak Ditemukan');
        $view->assertSee('Kembali ke Beranda');
    }

    public function test_403_error_view_exists_and_contains_expected_content(): void
    {
        $view = $this->view('errors.403');

        $view->assertSee('403');
        $view->assertSee('Akses Dibatasi');
        $view->assertSee('Kembali ke Portal');
    }

    public function test_500_error_view_exists_and_contains_expected_content(): void
    {
        $view = $this->view('errors.500');

        $view->assertSee('500');
        $view->assertSee('Terjadi Gangguan pada Server');
        $view->assertSee('Muat Ulang Halaman');
    }

    public function test_503_error_view_exists_and_contains_expected_content(): void
    {
        $view = $this->view('errors.503');

        $view->assertSee('503');
        $view->assertSee('Pemeliharaan Sistem');
        $view->assertSee('Periksa Kembali');
    }
}

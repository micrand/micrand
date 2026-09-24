<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertViewIs('pages.home');
    }

    public function test_root_url_points_to_home_page(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertViewIs('pages.home');
    }

    public function test_home_page_contains_expected_title(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSeeText(
                'Micrandria — Technology, Architecture & Digital Products',
                false
            );
    }
}
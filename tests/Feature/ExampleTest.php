<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class ExampleTest extends TestCase
{
    public function test_root_redirects_to_setup_when_not_configured(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('setup.index'));
    }
}

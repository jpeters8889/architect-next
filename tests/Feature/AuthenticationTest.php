<?php

namespace JPeters\Architect\Tests\Feature;

use Illuminate\Support\Facades\Gate;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Models\User;

class AuthenticationTest extends ArchitectTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('accessArchitect', fn($user) => $user->email === 'jamie@jamie-peters.co.uk');
    }

    /** @test */
    public function it_returns_an_error_when_a_user_is_not_logged_in()
    {
        $this->get('/admin')->assertStatus(403);
    }

    /** @test */
    public function it_returns_a_403_if_the_logged_in_user_is_not_authenticated()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get('/admin')->assertStatus(403);
    }

    /** @test */
    public function it_returns_success_when_the_user_authorised()
    {
        $this->actingAs(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));

        $this->get('/admin')->assertOk();
    }
}

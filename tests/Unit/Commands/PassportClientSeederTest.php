<?php


namespace Tests\Unit\Commands;

use App\Console\Commands\PassportClientSeederCommand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class PassportClientSeederTest
 * @package Tests\Unit\Commands
 */
class PassportClientSeederTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string|null
     */
    private $clientId;

    /**
     * @var string|null
     */
    private $clientSecret;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->clientId = env('PASSPORT_ACCESS_CLIENT_ID');
        $this->clientSecret = env('PASSPORT_ACCESS_CLIENT_SECRET');
    }

    /**
     * @test
     */
    public function test_it_updates_access_client_based_on_env_data()
    {
        $this->passportInstall();

        $this->artisan('dolphin:passport:seed')->assertExitCode(0);

        $this->assertDatabaseHas('oauth_clients', [
            'id' => $this->clientId,
            'secret' => $this->clientSecret,
        ]);
    }

    /**
     * @test
     */
    public function test_it_creates_new_client_based_on_env_data()
    {
        $this->artisan('dolphin:passport:seed')->assertExitCode(0);
        $this->assertDatabaseHas('oauth_clients', [
            'id' => $this->clientId,
            'secret' => $this->clientSecret,
        ]);
    }

    /**
     * @test
     */
    public function test_it_does_not_run_on_production()
    {
        $this->app['config']->set('app.env', 'production');
        $this->artisan('dolphin:passport:seed')
            ->assertExitCode(PassportClientSeederCommand::ERROR_RUN_IN_PRODUCTION);
    }
}

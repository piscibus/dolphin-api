<?php

namespace App\Console\Commands;

use App\Dolphin\Passport\Repositories\ClientRepository;
use Illuminate\Console\Command;
use Laravel\Passport\Client;

/**
 * Class PassportClientSeederCommand
 * @package App\Console\Commands
 */
class PassportClientSeederCommand extends Command
{
    public const ERROR_RUN_IN_PRODUCTION = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dolphin:passport:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed passport access clients.';

    /**
     * @var ClientRepository
     */
    private $clients;

    /**
     * Create a new command instance.
     *
     * @param  ClientRepository  $clients
     */
    public function __construct(ClientRepository $clients)
    {
        parent::__construct();
        $this->clients = $clients;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $environment = app()['config']->get('app.env');

        if ($environment === 'production') {
            $this->error('Seeding passport client on production is not allowed!');
            return self::ERROR_RUN_IN_PRODUCTION;
        }

        $this->updateClient();
        $this->showSuccessMessages();

        return 0;
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return $this->clients->find($this->getClientId()) ?? new Client();
    }

    /**
     * @return Client
     */
    private function updateClient(): Client
    {
        $client = $this->getClient();
        $client->fill([
            'id' => $this->getClientId(),
            'name' => 'Test Access Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => true,
            'revoked' => false,
            'secret' => $this->getClientSecret(),
        ]);
        $client->save();
        return $client;
    }

    /**
     * @return int|null
     */
    private function getClientId(): ?int
    {
        return config('dolphin.passport.client_id');
    }

    /**
     * @return string|null
     */
    private function getClientSecret(): ?string
    {
        return config('dolphin.passport.client_secret');
    }

    /**
     * Show success messages including the client id and secret
     */
    private function showSuccessMessages(): void
    {
        $this->info('Your client is ready to use!');
        $this->table(['id', 'secret'], [[$this->getClientId(), $this->getClientSecret()]]);
    }
}

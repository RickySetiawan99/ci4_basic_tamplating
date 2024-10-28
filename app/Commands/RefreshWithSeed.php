<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshWithSeed extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Database';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'migrate:refresh-seed';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Refresh migrations and run seeders.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        // Run migrate:refresh
        CLI::write('Refreshing migrations...', 'yellow');
        $this->call('migrate:refresh', ['--all' => true]);

        // Run db:seed DatabaseSeeder
        CLI::write('Seeding the database...', 'yellow');
        $this->call('db:seed', ['DatabaseSeeder']);
        
        CLI::write('Migrations refreshed and seeders run successfully!', 'green');
    }
}

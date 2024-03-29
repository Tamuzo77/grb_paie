<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Services');
        $path = $directory.'/'.$name.'.php';
        File::ensureDirectoryExists($directory);

        if (File::exists($path)) {
            $this->error('Service already exists!');

            return 1;
        }
        $stub = $this->getStub();
        $stub = str_replace('TamuzoService', $name, $stub);

        File::put($path, $stub);
        $this->info('Service created successfully.');

        return 0;
    }

    public function getStub()
    {
        return <<<EOT
<?php
namespace App\Services;


class TamuzoService
{
    //by Tamuzo
}
EOT;

    }
}

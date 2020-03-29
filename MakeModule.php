<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {name : Name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument("name");
        $ucname = ucfirst($name);
        $lowername = strtolower($name);
        $base_dir = "modules/{$ucname}";

        // Generate directories
        $dirs = ["Controllers", "Migrations", "Resources/views", "Resources/lang"];
        foreach ($dirs as $dir)
        {
            Storage::disk("root")->makeDirectory($base_dir . "/" . $dir);
        }

        // Generate routes file
        $routes = <<<EOT
<?php

Route::namespace("Modules\\$ucname\Controllers")
    ->name("{$lowername}.")
    ->prefix("{$lowername}")
    ->middleware(["web"])
    ->group(
        static function () {

            // Put your routes here
        
        }
    );

EOT;
        Storage::disk("root")->put("modules/{$ucname}/routes.php", $routes);

        // Generate ServiceProvider file
        $service_provider = <<<EOT
<?php

namespace Modules\\$name;

use Illuminate\Support\ServiceProvider;

class {$ucname}ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \$this->loadViewsFrom(__DIR__ . "/Resources/views", "{$lowername}");
        \$this->loadRoutesFrom(__DIR__ . "/routes.php");
        \$this->loadMigrationsFrom(__DIR__ . "/Migrations");
        \$this->loadTranslationsFrom(__DIR__ . "/Resources/lang", "{$lowername}");
    }
}
EOT;
        Storage::disk("root")->put("modules/{$ucname}/{$ucname}ServiceProvider.php", $service_provider);

        $this->info("Done! Don't forget to add {$ucname}ServiceProvider::class to config/app.php");
    }
}

<?php

namespace PortedCheese\SiteNews\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class NewsOverrideCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'override:news
                    {--admin : Scaffold admin}
                    {--site : Scaffold site}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change news default logic';

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
        if ($this->option('admin')) {
            $this->createController("Admin");
            $this->expandSiteRoutes('admin');
        }

        if ($this->option('site')) {
            $this->createController("Site");
            $this->expandSiteRoutes('web');
        }
    }

    /**
     * Добавляет роуты.
     */
    protected function expandSiteRoutes($place)
    {
        if (! $this->confirm("Do you want add routes to {$place}.php file?")) {
            return;
        }

        file_put_contents(
            base_path("routes/{$place}.php"),
            file_get_contents(__DIR__ . "/stubs/make/{$place}.stub"),
            FILE_APPEND
        );

        $this->info("Routes added to {$place}.php");
    }

    /**
     * Create controller for news.
     */
    protected function createController($place)
    {
        if (file_exists($controller = app_path("Http/Controllers/News/{$place}/NewsController.php"))) {
            if (! $this->confirm("The [{$place}/NewsController.php] controller already exists. Do you want to replace it?")) {
                return;
            }
        }

        if (! is_dir($directory = app_path("Http/Controllers/News/{$place}"))) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            app_path("Http/Controllers/News/{$place}/NewsController.php"),
            $this->compileControllerStub($place)
        );

        $this->info("[{$place}/NewsController.php] created");
    }

    /**
     * Compiles the NewsController stub.
     *
     * @return string
     */
    protected function compileControllerStub($place)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__ . "/stubs/make/controllers/{$place}NewsController.stub")
        );
    }
}

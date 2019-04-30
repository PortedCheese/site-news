<?php

namespace PortedCheese\SiteNews\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class NewsMakeCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:news
                    {--config : Only set config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (! $this->option('config')) {
            $this->createDirectories();

            $this->createController();

            $this->expandRoutes();
        }

        $this->makeConfig();
    }

    /**
     * Добавить настройки новостей по умолчанию.
     */
    public function makeConfig()
    {
        $config = siteconf()->get('news');
        if (!empty($config)) {
            if (! $this->confirm("News config already exists. Replace it?")) {
                return;
            }
        }

        siteconf()->save("news", [
            'pager' => 20,
            'path' => 'news',
            'customTheme' => null,
        ]);

        $this->info("Config reviews added to siteconfig");
    }

    /**
     * Добавляет роуты.
     */
    protected function expandRoutes()
    {
        if (! $this->confirm("Do you want add routes to web.php file?")) {
            return;
        }

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/stubs/make/routes.stub'),
            FILE_APPEND
        );
    }

    /**
     * Create controller for news.
     */
    protected function createController()
    {
        if (file_exists($controller = app_path('Http/Controllers/Site/NewsController.php'))) {
            if (! $this->confirm("The [NewsController.php] controller already exists. Do you want to replace it?")) {
                return;
            }
        }

        file_put_contents(
            app_path("Http/Controllers/Site/NewsController.php"),
            $this->compileControllerStub()
        );
    }

    /**
     * Compiles the NewsController stub.
     *
     * @return string
     */
    protected function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__ . '/stubs/make/controllers/NewsController.stub')
        );
    }

    /**
     * Creare the directories for the files.
     */
    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('views/site/news'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path("Http/Controllers/Site"))) {
            mkdir($directory, 0755, true);
        }
    }
}

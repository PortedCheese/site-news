<?php

namespace PortedCheese\SiteNews\Console\Commands;

use Illuminate\Console\Command;

class NewsMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:news-conf';

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
            'useOwnAdminRoutes' => false,
            'useOwnSiteRoutes' => false,
        ]);

        $this->info("Config news added to siteconfig");
    }
}

<?php

namespace PortedCheese\SiteNews\Console\Commands;

use App\Menu;
use App\MenuItem;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;

class NewsMakeCommand extends BaseConfigModelCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:news
                    {--all : Run all}
                    {--menu : Config menu}
                    {--models : Export models}
                    {--policies : Export and create rules}
                    {--only-default : Create default rules}
                    {--controllers : Export controllers}
                    {--config : Make config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $packageName = "SiteNews";

    /**
     * The models that need to be exported.
     * @var array
     */
    protected $models = ['News'];

    protected $controllers = [
        "Admin" => ["NewsController"],
        "Site" => ["NewsController"],
    ];

    protected $configName = "news";
    protected $configTitle = "Новости";
    protected $configTemplate = "site-news::admin.settings";
    protected $configValues = [
        'pager' => 20,
        'path' => 'news',
    ];

    protected $ruleRules = [
        [
            "title" => "Новости",
            "slug" => "news",
            "policy" => "NewsPolicy",
        ],
    ];

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
     */
    public function handle()
    {
        $all = $this->option("all");

        if ($this->option("menu") || $all) {
            $this->makeMenu();
        }

        if ($this->option("models") || $all) {
            $this->exportModels();
        }

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
            $this->exportControllers("Site");
        }

        if ($this->option("config") || $all) {
            $this->makeConfig();
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();
        }
    }

    protected function makeMenu()
    {
        try {
            $menu = Menu::query()
                ->where('key', 'admin')
                ->firstOrFail();
        }
        catch (\Exception $e) {
            return;
        }

        $title = "Новости";
        $itemData = [
            'title' => $title,
            'template' => "site-news::admin.news.menu",
            'url' => "#",
            'ico' => 'far fa-newspaper',
            'menu_id' => $menu->id,
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where('title', $title)
                ->firstOrFail();
            $menuItem->update($itemData);
            $this->info("Элемент меню '$title' обновлен");
        }
        catch (\Exception $e) {
            MenuItem::create($itemData);
            $this->info("Элемент меню '$title' создан");
        }
    }
}

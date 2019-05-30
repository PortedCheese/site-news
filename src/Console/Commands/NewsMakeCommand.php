<?php

namespace PortedCheese\SiteNews\Console\Commands;

use App\Menu;
use App\MenuItem;
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
    protected $signature = 'make:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The models that need to be exported.
     * @var array
     */
    protected $models = [
        'News.stub' => 'News.php',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $namespace = $this->getAppNamespace();
        $this->namespace = str_replace("\\", '', $namespace);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->makeConfig();
        $this->exportModels();
        $this->makeMenu();
    }

    protected function makeMenu()
    {
        try {
            $menu = Menu::where('key', 'admin')->firstOrFail();
        }
        catch (\Exception $e) {
            return;
        }

        $title = "Новости";
        $itemData = [
            'title' => $title,
            'template' => "site-news::admin.news.menu",
            'url' => "#",
            'class' => '@far fa-newspaper',
            'menu_id' => $menu->id,
        ];

        try {
            $menuItem = MenuItem::where('title', $title)->firstOrFail();
            $menuItem->update($itemData);
            $this->info("Элемент меню '$title' обновлен");
        }
        catch (\Exception $e) {
            $menuItem = MenuItem::create($itemData);
            $this->info("Элемент меню '$title' создан");
        }
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

    /**
     * Create models files.
     */
    protected function exportModels()
    {
        foreach ($this->models as $key => $model) {
            if (file_exists(app_path($model))) {
                if (!$this->confirm("The [{$model}] model already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            file_put_contents(
                app_path($model),
                $this->compileModetStub($key)
            );

            $this->info("Model [{$model}] generated successfully.");
        }
    }

    /**
     * Replace namespace in model.
     *
     * @param $model
     * @return mixed
     */
    protected function compileModetStub($model)
    {
        return str_replace(
            '{{namespace}}',
            $this->namespace,
            file_get_contents(__DIR__ . "/stubs/make/models/$model")
        );
    }
}

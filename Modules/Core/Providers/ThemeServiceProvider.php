<?php
namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Classes\ThemeFinder;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->registerThemeFinder();

        // $this->registerSolutionProvider();
    }

    protected function registerSolutionProvider(): void
    {
        $solutionProvider = $this->app->make(SolutionProviderRepository::class);

            $solutionProvider->registerSolutionProvider(
                ThemeSolutionProvider::class
            );
    }

    protected function registerThemeFinder(): void
    {
        $this->app->singleton('theme.finder', function ($app) {
            $themeFinder = new ThemeFinder(
                $app['files'],
                $app['config']['view.paths']
            );

            // $themeFinder = new ThemeFinder(
            //     Container::getInstance()->make('files'),
            //     Container::getInstance()->make('config')['view.paths']
            // );

            $themeFinder->setHints(
                $this->app->make('view')->getFinder()->getHints()
            );

            return $themeFinder;
        });

        if (config('core.theme.active')) {
            $this->app->make('theme.finder')->setActiveTheme(config('core.theme.active'));
        }

        // If need to replace Laravel's view finder with package's theme.finder
        // $this->app->make('view')->setFinder($this->app->make('theme.finder'));
    }
}
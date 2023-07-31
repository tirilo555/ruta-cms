<?php

namespace Modules\Core\Classes;

use Illuminate\View\FileViewFinder;
use Qirolab\Theme\Exceptions\ThemeBasePathNotDefined;

class ThemeFinder extends FileViewFinder
{
    /**
     * @var null|string
     */
    protected $activeTheme;

    /**
     * @var null|string
     */
    protected $parentTheme;

    public function getViewFinder()
    {
        // It should return `theme.finder` if Laravel's view finder is replaced
        // with package's finder.
        // return app('theme.finder');

        return app('view')->getFinder();
    }

    public function setActiveTheme(string $theme): void
    {
        if ($theme) {
            $this->clearThemes();

            $this->registerTheme($theme);

            $this->activeTheme = $theme;
        }
    }

    public function setHints($hints): void
    {
        $this->hints = $hints;
    }

    public function getThemePath(string $theme, string $path = null): string
    {
        if (! config('core.theme.base_path')) {
            throw new \Exception('Theme base path is not defined');
        }

        return $this->resolvePath(
            config('core.theme.base_path') . DIRECTORY_SEPARATOR . $theme . ($path ? DIRECTORY_SEPARATOR . $path : '')
        );
    }

    public function getThemeViewPath(string $theme = null): string
    {
        $theme = $theme ?? $this->getActiveTheme();

        return $this->getThemePath($theme, 'views');
    }

    /**
     * Get active theme name.
     *
     * @return null|string
     */
    public function getActiveTheme()
    {
        return $this->activeTheme;
    }

    /**
     * Get parent theme name.
     *
     * @return null|string
     */
    public function getParentTheme()
    {
        return $this->parentTheme;
    }

    public function clearThemes(): void
    {
        $paths = $this->getViewFinder()->getPaths();

        if ($this->getActiveTheme()) {
            if (($key = array_search($this->getThemeViewPath($this->getActiveTheme()), $paths)) !== false) {
                unset($paths[$key]);
            }
        }

        if ($this->getParentTheme()) {
            if (($key = array_search($this->getThemeViewPath($this->getParentTheme()), $paths)) !== false) {
                unset($paths[$key]);
            }
        }

        $this->activeTheme = null;
        $this->parentTheme = null;
        $this->getViewFinder()->setPaths($paths);
    }

    public function registerTheme(string $theme): void
    {
        // array_unshift($this->paths, $this->getThemeViewPath($theme));

        $this->getViewFinder()->prependLocation($this->getThemeViewPath($theme));

        $this->registerNameSpacesForTheme($theme);
    }

    public function registerNameSpacesForTheme(string $theme): void
    {
        $vendorViewsPath = $this->getThemeViewPath($theme) . DIRECTORY_SEPARATOR . 'vendor';

        if (is_dir($vendorViewsPath)) {
            $directories = scandir($vendorViewsPath);

            foreach ($directories as $namespace) {
                if ($namespace != '.' && $namespace != '..') {
                    $path = $vendorViewsPath . DIRECTORY_SEPARATOR . $namespace;
                    $this->getViewFinder()->prependNamespace($namespace, $path);
                }
            }
        }
    }
}
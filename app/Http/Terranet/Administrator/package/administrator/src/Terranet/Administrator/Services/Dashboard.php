<?php

namespace Terranet\Administrator\Services;

use Illuminate\Filesystem\Filesystem;
use Terranet\Administrator\Contracts\Services\Widgetable;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Traits\ResolvesClasses;
use Terranet\Administrator\Traits\SortsObjectsCollection;

class Dashboard
{
    use ResolvesClasses, SortsObjectsCollection;

    /**
     * @var array
     */
    private $widgets;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     *
     * @throws Exception
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function widgets()
    {
        if (null === $this->widgets) {
            $this->collectWidgets();
        }

        return $this->widgets;
    }

    protected function collectWidgets()
    {
        $container = app_path(
            app('scaffold.config')->get('path.panel')
        );

        foreach ($this->filesystem->allFiles($container) as $fileInfo) {
            $this->resolveClass($fileInfo, function ($widget) {
                if (!$widget instanceof Widgetable) {
                    throw new Exception('Dashboard Widget must implement '.Widgetable::class.' contract');
                }

                $this->widgets[] = $widget;
            });
        }

        $this->widgets = $this->sortCollection($this->widgets);
    }
}

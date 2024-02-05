<?php

namespace Xiaohuilam\Flysystem\MultipleDisks;

class MultipleDisksManager
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function disk($name = null)
    {
        return $this->app['filesystem']->disk($name);
    }
}

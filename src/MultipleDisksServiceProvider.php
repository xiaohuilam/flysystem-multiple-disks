<?php

namespace Xiaohuilam\Flysystem\MultipleDisks;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use League\Flysystem\Filesystem;

class MultipleDisksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app instanceof LumenApplication) {
            $this->app->configure('filesystems');
        }

        $this->app->make('filesystem')
            ->extend('multi', function ($app, $config) {
                $disks = collect($config['disks'])->map(function ($disk) use ($app) {
                    return $app->make('filesystem')->disk($disk);
                });
                $adapter = new Adapter($disks, $config);
                $filesystem = new FilesystemAdapter(new Filesystem($adapter), $adapter, $config);

                return $filesystem;
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/filesystems.php',
            'filesystems'
        );
    }
}

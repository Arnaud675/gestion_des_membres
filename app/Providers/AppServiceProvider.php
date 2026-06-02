<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\GoogleCloudStorage\PortableVisibilityHandler;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Storage::extend('gcs', function ($app, array $config) {
            $client = new StorageClient([
                'projectId' => $config['project_id'] ?? null,
            ]);

            $bucket = $client->bucket($config['bucket']);

            $adapter = new GoogleCloudStorageAdapter(
                $bucket,
                $config['path_prefix'] ?? '',
                new PortableVisibilityHandler()
            );

            $driver = new Filesystem($adapter);

            return new FilesystemAdapter($driver, $adapter, $config);
        });
    }
}

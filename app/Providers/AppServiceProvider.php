<?php

namespace App\Providers;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
    {
        Storage::extend('gcs', function ($app, $config) {

            // Si estás usando base64 en el config, ya viene decodificado en $config['key_file']
            $client = new StorageClient([
                'projectId' => $config['project_id'],
                'keyFile'   => $config['key_file'] ?: null,
            ]);

            $bucket = $client->bucket($config['bucket']);

            $adapter = new GoogleCloudStorageAdapter(
                $bucket,
                $config['path_prefix'] ?? ''
            );

            $driver = new Flysystem($adapter);

            // Devolver FilesystemAdapter para que Laravel esté contento
            return new FilesystemAdapter($driver, $adapter, $config);
        });
    }
}

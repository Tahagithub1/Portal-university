<?php

namespace misterspelik\LaravelPdf\Providers;

use Illuminate\Support\ServiceProvider;
use misterspelik\LaravelPdf\LaravelPdfFactory;
use misterspelik\LaravelPdf\Wrapper\PdfWrapperInterface;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var \misterspelik\LaravelPdf\LaravelPdfFactory|null
     */
    protected $factory = null;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->factory = new LaravelPdfFactory();
    }

    /**
     * Bootstrap the application service
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/pdf.php' => config_path('pdf.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/pdf.php', 'pdf'
        );

        $this->app->bind('mpdf.wrapper', function ($app) {
            return $this->getPdfWrapper();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'mpdf.pdf'
        ];
    }

    /**
     * @return \misterspelik\LaravelPdf\Wrapper\PdfWrapperInterface
     */
    protected function getPdfWrapper(): PdfWrapperInterface
    {
        return $this->factory->createPdfWrapper();
    }
}

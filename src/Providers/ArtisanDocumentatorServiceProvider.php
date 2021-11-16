<?php

namespace ArtARTs36\ArtisanDocumentator\Providers;

use ArtARTs36\ArtisanDocumentator\Contexts\DocGenerateContext;
use ArtARTs36\ArtisanDocumentator\Contracts\CommandsFetcher;
use ArtARTs36\ArtisanDocumentator\Documentators\ConfigDocumentatorFactory;
use ArtARTs36\ArtisanDocumentator\Documentators\SignatureBuilder;
use ArtARTs36\ArtisanDocumentator\Documentators\TemplateDocumentator;
use ArtARTs36\ArtisanDocumentator\Fetchers\AppCommandsFetcher;
use ArtARTs36\ArtisanDocumentator\Ports\Console\GenerateDocCommand;
use ArtARTs36\ArtisanDocumentator\Support\Ci;
use ArtARTs36\CiGitSender\Contracts\Sender;
use ArtARTs36\CiGitSender\Remote\Credentials;
use ArtARTs36\CiGitSender\Sender\Factory\SenderFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ArtisanDocumentatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(CommandsFetcher::class, AppCommandsFetcher::class);

        $this->mergeConfigFrom(__DIR__ . '/../../config/artisan_documentator.php', 'artisan_documentator');

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'artisan_documentator');
        $this->registerTemplateDocumentator();
        $this->registerDocGenerateContext();

        $this->commands(GenerateDocCommand::class);

        $this->app->bind(ConfigDocumentatorFactory::class, static function (Container $container) {
            $map = [];
            
            foreach ($container['config']->get('artisan_documentator.documentators.drivers') as $driver => $config) {
                $map[$driver] = $config['class'];
            }
            
            return new ConfigDocumentatorFactory($container, $map);
        });

        $this->registerCi();
    }

    protected function registerCi(): void
    {
        $git = $this->app->get('config')->get('artisan_documentator.git');

        $this
            ->app
            ->when(Ci::class)
            ->needs(Sender::class)
            ->give(static function () use ($git) {
                return SenderFactory::local()->create($git['dir'], Credentials::fromArray($git['remote']));
            });
    }

    private function registerDocGenerateContext(): void
    {
        $this->app->bind(DocGenerateContext::class, static function (Container $container) {
            return new DocGenerateContext($container['config']->get('artisan_documentator.namespaces'));
        });
    }

    private function registerTemplateDocumentator(): void
    {
        $this->app->bind(TemplateDocumentator::class, static function (Container $container) {
            return new TemplateDocumentator(
                $container->make(Factory::class),
                $container->make(SignatureBuilder::class),
                $container['config']->get('artisan_documentator.documentators.drivers.template.view')
            );
        });
    }

    private function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/artisan_documentator.php' => $this->app->configPath('artisan_documentator.php'),
        ], 'config');
    }
}

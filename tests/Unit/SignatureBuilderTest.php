<?php

namespace ArtARTs36\ArtisanDocumentator\Tests\Unit;

use ArtARTs36\ArtisanDocumentator\Documentators\SignatureBuilder;
use Illuminate\Console\Command as LaravelCommand;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use ArtARTs36\ArtisanDocumentator\Tests\TestCase;
use Symfony\Component\Console\Input\InputOption;

final class SignatureBuilderTest extends TestCase
{
    public function providerForTestBuild(): array
    {
        return [
            [
                new class extends LaravelCommand {
                    protected $signature = 'app:users:delete {userId} {--force} {--notify-after-days=}';
                },
                "app:users:delete {userId} {--force}\n {--notify-after-days=}",
            ],
            [
                new class extends SymfonyCommand {
                    protected static $defaultName = 'app:users:delete';

                    protected function configure()
                    {
                        $this->addArgument('userId');
                        $this->addOption('force');
                        $this->addOption(
                            'notify-after-days',
                            mode: InputOption::VALUE_REQUIRED,
                            description: 'count days'
                        );
                    }
                },
                "app:users:delete {userId} {--force}\n {--notify-after-days=: count days}",
            ],
        ];
    }

    /**
     * @dataProvider providerForTestBuild
     * @covers \ArtARTs36\ArtisanDocumentator\Documentators\SignatureBuilder::build
     * @covers \ArtARTs36\ArtisanDocumentator\Documentators\SignatureBuilder::buildOptions
     */
    public function testBuild(SymfonyCommand $command, string $expectedSignature): void
    {
        $builder = new SignatureBuilder();

        self::assertEquals($expectedSignature, $builder->build($command));
    }
}

<?php

namespace ArtARTs36\ArtisanDocumentator\Tests\Unit;

use ArtARTs36\ArtisanDocumentator\Fetchers\AppCommandsFetcher;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\Kernel;
use ArtARTs36\ArtisanDocumentator\Tests\TestCase;

final class AppCommandsFetcherTest extends TestCase
{
    public function providerForTestFetch(): array
    {
        return [
            [
                $oneCommands = [
                    new Command(),
                    new Command(),
                ],
                [],
                [
                    'all' => $oneCommands,
                ],
            ],
            [
                [
                    $usersDelete = new class extends Command {
                        protected $signature = 'app:users:delete';
                    },
                    $usersFind = new class extends Command {
                        protected $signature = 'app:users:find';
                    },
                    $postsFind = new class extends Command {
                        protected $signature = 'app:posts:find';
                    },
                ],
                ['app:users:', 'app:posts:'],
                [
                    'app:users:' => [
                        'app:users:delete' => $usersDelete,
                        'app:users:find'   => $usersFind,
                    ],
                    'app:posts:' => [
                        'app:posts:find' => $postsFind,
                    ],
                ]
            ],
        ];
    }

    /**
     * @dataProvider providerForTestFetch
     * @covers \ArtARTs36\ArtisanDocumentator\Fetchers\AppCommandsFetcher::fetch
     * @covers \ArtARTs36\ArtisanDocumentator\Fetchers\AppCommandsFetcher::filterCommands
     */
    public function testFetch(array $allCommands, array $namespaces, array $expectedCommands): void
    {
        $kernel = new class($allCommands) extends Kernel {
            public function __construct(array $commands)
            {
                $this->commands = $commands;
            }

            public function all()
            {
                return $this->commands;
            }
        };

        $fetcher = new AppCommandsFetcher($kernel);

        self::assertEquals($expectedCommands, $fetcher->fetch($namespaces));
    }
}

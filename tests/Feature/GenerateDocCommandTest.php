<?php

namespace ArtARTs36\ArtisanDocumentator\Tests\Feature;

use ArtARTs36\ArtisanDocumentator\Ports\Console\GenerateDocCommand;
use ArtARTs36\ArtisanDocumentator\Tests\TestCase;
use Illuminate\Console\Command;

final class GenerateDocCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ArtisanDocumentator\Ports\Console\GenerateDocCommand::handle
     */
    public function testHandleOnDocumentationUpdated(): void
    {
        $this
            ->artisan(GenerateDocCommand::class, [
                'path' => 'commands.md',
            ])
            ->assertExitCode(Command::SUCCESS)
            ->assertSuccessful()
            ->run();
    }
}

<?php

namespace ArtARTs36\ArtisanDocumentator\Support;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Making\MakingPush;
use Illuminate\Config\Repository;
use Psr\Http\Message\UriInterface;

class Repo
{
    public function __construct(
        private GitHandler $git,
        private string $login,
        private string $token,
        private string $message,
    ) {
        //
    }

    public function commitAndPush(string $path, string $branch): void
    {
        $this->git->index()->add($path);
        $this->git->commits()->commit($this->message);

        $this->git->pushes()->send(function (MakingPush $push) use ($branch) {
            $push->onRemote(function (UriInterface $uri) {
                return $uri->withUserInfo($this->login, $this->token);
            })->onSetUpStream()->onBranchHead($branch);
        });
    }
}

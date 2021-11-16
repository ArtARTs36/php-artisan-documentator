<?php

namespace ArtARTs36\ArtisanDocumentator\Support;

use ArtARTs36\CiGitSender\Commit\Message;
use ArtARTs36\CiGitSender\Contracts\Sender;

class Ci
{
    public function __construct(
        protected Sender $sender,
        protected Message $message,
    ) {
        //
    }

    public function sendDoc(string $file): void
    {
        $this->sender->send($file, $this->message);
    }
}

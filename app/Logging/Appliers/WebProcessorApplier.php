<?php

namespace App\Logging\Appliers;

use Illuminate\Log\Logger;
use Monolog\Processor\WebProcessor;

class WebProcessorApplier
{
    public function __invoke(Logger $logger)
    {
        $logger->pushProcessor(new WebProcessor());
    }
}

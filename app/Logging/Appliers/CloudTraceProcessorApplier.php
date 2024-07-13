<?php

namespace App\Logging\Appliers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Log\Logger;

class CloudTraceProcessorApplier
{
    protected $request;
    protected $project;

    public function __construct(Request $request, Config $config)
    {
        $this->request = $request;
        $this->project = $config->get('cloud.project_id');
    }

    public function __invoke(Logger $logger)
    {
        $logger->pushProcessor(function (array $record) {
            $trace = explode('/', $this->request->header('X-Cloud-Trace-Context'))[0];

            if ($this->project !== null && $trace !== '') {
                $record['logging.googleapis.com/trace'] = "projects/$this->project/traces/$trace";
            }

            return $record;
        });
    }
}

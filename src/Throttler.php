<?php
namespace Ob_Ivan\Throttler;

class Throttler {
    private $maxRequests;
    private $periodSeconds;

    private $firstRequestTime = null;
    private $requestCount = 0;

    public function __construct(
        int $maxRequests,
        float $periodSeconds
    ) {
        $this->maxRequests = $maxRequests;
        $this->periodSeconds = $periodSeconds;
    }

    public function run(JobInterface $job) {
        while ($job->next()) {
            if ($this->requestCount >= $this->maxRequests) {
                usleep(
                    1000000 *
                    ceil($this->firstRequestTime + $periodSeconds - microtime(true))
                );
                $this->firstRequestTime = null;
                $this->requestCount = 0;
            }
            if ($this->firstRequestTime === null) {
                $this->firstRequestTime = microtime(true);
            }
            ++$this->requestCount;
            $job->execute();
        }
    }
}

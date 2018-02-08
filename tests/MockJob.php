<?php
namespace tests;

use Ob_Ivan\Throttler\JobInterface;

class MockJob implements JobInterface {
    private $maxRuns;
    private $currentRun = 0;
    private $microTimes = [];

    public function __construct(int $maxRuns) {
        $this->maxRuns = $maxRuns;
    }

    public function next(): bool {
        return ++$this->currentRun < $this->maxRuns;
    }

    public function execute() {
        $this->microTimes[] = microtime(true);
    }

    public function getMicroTimes() {
        return $this->microTimes;
    }
}

<?php
namespace tests;

use PHPUnit\Framework\TestCase;

class ThrottlerTest extends TestCase {
    public function testRunJob() {
        $maxRequests = 10;
        $periodSeconds = 1;
        $maxRuns = 20;
        $throttler = new Throttler($maxRequests, $periodSeconds);
        $job = new SpyJob($maxRuns);
        $throttler->run($job);
        $runs = $job->getRuns();
    }
}

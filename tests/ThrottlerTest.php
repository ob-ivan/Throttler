<?php
namespace tests;

use Ob_Ivan\Throttler\Throttler;
use PHPUnit\Framework\TestCase;

class ThrottlerTest extends TestCase {
    public function testRunJob() {
        $maxRequests = 10;
        $periodSeconds = 1;
        $maxRuns = 20;
        $throttler = new Throttler($maxRequests, $periodSeconds);
        $job = new MockJob($maxRuns);
        $throttler->run($job);
        $microTimes = $job->getMicroTimes();
        for ($i = 0; $i < 10; ++$i) {
            $diff = $microTimes[$i + $maxRequests] - $microTimes[$i];
            $this->assertGreaterThan(
                $periodSeconds,
                $diff,
                'Must keep long enough intervals between runs'
            );
            $this->assertLessThan(
                $periodSeconds * 1.5,
                $diff,
                'Should not make intervals too long'
            );
        }
    }
}

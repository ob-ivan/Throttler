<?php
namespace Ob_Ivan\Throttler;

class Throttler {
    private $maxRequestsPerMinute;
    private $getdata;
    private $apirequest;

    private $firstRequestTime = null;
    private $requestCount = 0;

    public function __construct(
        int $maxRequestsPerMinute,
        $getdata,
        $apirequest
    ) {
        $this->maxRequestsPerMinute = $maxRequestsPerMinute;
        $this->getdata = $getdata;
        $this->apirequest = $apirequest;
    }

    public function run() {
        while ($data = call_user_func($this->getdata)) {
            if ($this->requestCount >= $this->maxRequestsPerMinute) {
                sleep(ceil($this->firstRequestTime + 60 - microtime(true)));
                $this->firstRequestTime = null;
                $this->requestCount = 0;
            }
            if ($this->firstRequestTime === null) {
                $this->firstRequestTime = microtime(true);
            }
            ++$this->requestCount;
            call_user_func($this->apirequest, $data);
        }
    }
}

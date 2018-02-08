<?php
namespace Ob_Ivan\Throttler;

interface JobInterface {
    public function next(): bool;
    public function execute();
}

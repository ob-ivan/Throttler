<?php
namespace Ob_Ivan\Throttler;

interface JobInterface {
    /**
     * Advance the job to the next piece and tell if there is any.
     *
     * You may want to prefetch here any data to be sent on job execution.
     * This way execution time will not be wasted on data fetching.
     *
     * @return bool True to continue execution. False to exit the loop.
     */
    public function next(): bool;

    /**
     * Perform the action the job is designed for.
     *
     * It may include API calls, querying databases, processing job queues etc.
     * No return value is expected from this method. If you want to retrieve the data
     * obtained during the job execution, please rely on side effects.
     */
    public function execute();
}

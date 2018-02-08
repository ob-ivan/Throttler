# Throttler

Execute tasks in a loop at limited rate.

This answers a question on StackOverflow: https://stackoverflow.com/questions/48547971/restrict-function-to-maximum-100-executions-per-minute/48551632

Other implementations of the same idea you may want to have a look at:
- https://packagist.org/packages/franzip/throttler
- https://packagist.org/packages/andrey-mashukov/throttler
- https://packagist.org/packages/queryyetsimple/throttler

## Installation

    composer require ob-ivan/throttler
    
## Usage

Suppose you want to send requests to an API based on data from DB, but the API only allows 100 requests per minute.

You can use a throttler to do that like this:

```php
use Ob_Ivan\Throttler\Throttler;

$throttler = new Throttler(
    100, // number of requests
    60 // number of seconds in a unit of time
);
$throttler->run($job);
```

The `$job` variable here stands for your implementation of `JobInterface`:

```php
use Ob_Ivan\Throttler\JobInterface;

class MyAwesomeJob implements JobInterface {
    private $id;
    private $requestData;
    private $responseData = [];

    /**
     * Advance the job to the next piece and tell if there is any.
     *
     * Prefetch the data to be sent on job execution.
     * This way execution time will not be wasted on data fetching.
     *
     * @return bool True to continue execution. False to exit the loop.
     */
    public function next(): bool {
        ++$id;
        $row = $this->getRow($id);
        if ($row) {
            $this->requestData = $this->makeRequestData($row);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Perform the action the job is designed for.
     *
     * No return value is expected from this method.
     * We rely on side effects to retrieve the response data.
     */
    public function execute() {
        $response = $this->requestApi($this->requestData);
        $this->responseData[] = $this->extractResponseData($response);
    }

    // ...
}
```

And that's it.

## Development

To install phpunit locally:

    composer install
    
To run tests:

    vendor/bin/phpunit
    
## License

MIT

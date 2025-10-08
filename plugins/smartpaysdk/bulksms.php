<?php
require "vendor/autoload.php";
// Send an asynchronous request.
// $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');

// for($i=0; $i < 100; $i++){
// $promise = $client->sendAsync($request)->then(function ($response) {
//     echo 'I completed! ' . $response->getBody();
// });
// $promise->wait();
// }

$client = new GuzzleHttp\Client(['timeout' => 20]);

$iterator = function () use ($client) {
    $index = 0;
    while (true) {
        if ($index === 10) {
            break;
        }

        $url = 'http://localhost/lab/callbacks/log.php?name=' . $index++;
        $request = new \GuzzleHttp\Psr7\Request('GET', $url, []);

        echo "Queuing $url @ " . date('Y-m-d H:i:s') . PHP_EOL;

        yield $client
            ->sendAsync($request)
            ->then(function (Response $response) use ($request) {
                return [$request, $response];
            });

    }
};

$promise = \GuzzleHttp\Promise\each_limit(
    $iterator(),
    10,  /// concurrency,
    function ($result, $index) {
        /** @var GuzzleHttp\Psr7\Request $request */
        list($request, $response) = $result;
        echo (string)$request->getUri() . ' completed ' . PHP_EOL;
    }
);
$promise->wait();
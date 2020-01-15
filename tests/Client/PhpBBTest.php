<?php

declare(strict_types=1);

namespace Doublespark\ContaoForumBridgeBundle\Tests\Client;

use Doublespark\ContaoForumBridgeBundle\Client\PhpBB;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class PhpBBTest extends \PHPUnit\Framework\TestCase {

    public function testCreatesTokenUsingKey()
    {
        // Set global
        $_SERVER['SERVER_ADDR'] = '127.0.1';

        // Mock response
        $apiResponse = [
            'status'  => 'success',
            'message' => 'phpBB user was deleted',
            'data' => [
                'user_id' => 10
            ]
        ];

        // Set global
        $_SERVER['SERVER_ADDR'] = '127.0.1';

        // Set up mock responses from http client
        $mock = new MockHandler([
            new Response(200,[],json_encode($apiResponse))
        ]);

        // Create history middle to watch requests
        $container = [];
        $history = Middleware::history($container);

        // Create handler
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        // Create http client
        $client = new Client(['handler' => $handlerStack]);

        $phpbb = new PhpBB($client,'http://mock.url', '/api/path');
        $phpbb->setSecretKey('testing_key');

        $phpbb->deleteUser(10);

        /**
         * @var Request $request
         */
        $request = $container[0]['request'];

        $token = $request->getHeader('X-Contao-Token');

        $expectedToken = md5('phpbbbridge'.date('d/m/Y').$_SERVER['SERVER_ADDR'].'testing_key');

        $this->assertEquals($expectedToken,$token[0]);
    }

    public function testCreateUser()
    {
        // Mock response
        $apiResponse = [
            'status'  => 'success',
            'message' => 'phpBB user created',
            'data' => [
                'user_id' => 10
            ]
        ];

        // Set global
        $_SERVER['SERVER_ADDR'] = '127.0.1';

        // Set up mock responses from http client
        $mock = new MockHandler([
            new Response(200,[],json_encode($apiResponse))
        ]);

        // Create history middle to watch requests
        $container = [];
        $history = Middleware::history($container);

        // Create handler stack
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        // Create http client
        $client = new Client(['handler' => $handlerStack]);

        // Create phpbb
        $phpbb = new PhpBB($client,'http://mock.url', '/api/path');

        // Run create user
        $arrResult = $phpbb->createUser('test_username','test_password', 'test@email.com', 1);

        /**
         * @var Request $request
         */
        $request = $container[0]['request'];

        $this->assertEquals('POST',$request->getMethod());
        $this->assertEquals('http://mock.url/api/path?act=createUser',(string)$request->getUri());

        $this->assertEquals($apiResponse,$arrResult);
    }

    public function testDeleteUser()
    {
        // Mock response
        $apiResponse = [
            'status'  => 'success',
            'message' => 'phpBB user was deleted',
            'data' => [
                'user_id' => 10
            ]
        ];

        // Set global
        $_SERVER['SERVER_ADDR'] = '127.0.1';

        // Set up mock responses from http client
        $mock = new MockHandler([
            new Response(200,[],json_encode($apiResponse))
        ]);

        // Create history middle to watch requests
        $container = [];
        $history = Middleware::history($container);

        // Create handler stack
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        // Create http client
        $client = new Client(['handler' => $handlerStack]);

        // Create phpbb
        $phpbb = new PhpBB($client,'http://mock.url', '/api/path');

        // Run create user
        $arrResult = $phpbb->deleteUser(10);

        /**
         * @var Request $request
         */
        $request = $container[0]['request'];

        $this->assertEquals('POST',$request->getMethod());
        $this->assertEquals('http://mock.url/api/path?act=deleteUser',(string)$request->getUri());

        $this->assertEquals($apiResponse,$arrResult);
    }
}
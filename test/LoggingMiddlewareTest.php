<?php declare(strict_types=1);
/**
 * PSR-7 logging middleware
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 * @link    https://github.com/alwynn/psr7-logging-middleware
 * @license MIT
 */
namespace Psr7\Middleware\Logging;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PHPUnit\Framework\TestCase;

class LoggingMiddlewareTest extends TestCase
{
    public function testProcess()
    {
        $headers = [
            'Content-type' => 'text/html'
        ];

        $requestStream = $this->getMockForAbstractClass(StreamInterface::class);
        $requestStream->expects($this->once())
            ->method('getSize')
            ->will($this->returnValue(123));

        $request = $this->getMockForAbstractClass(ServerRequestInterface::class);
        $request->expects($this->once())
            ->method('getProtocolVersion')
            ->will($this->returnValue('1.1'));
        $request->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('GET'));
        $request->expects($this->once())
            ->method('getUri')
            ->will($this->returnValue('test.test'));
        $request->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($requestStream));
        $request->expects($this->once())
            ->method('getHeaders')
            ->will($this->returnValue($headers));

        $responseStream = $this->getMockForAbstractClass(StreamInterface::class);
        $responseStream->expects($this->once())
            ->method('getSize')
            ->will($this->returnValue(456));

        $response = $this->getMockForAbstractClass(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($responseStream));

        $handler = $this->getMockForAbstractClass(RequestHandlerInterface::class);
        $handler->method('handle')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));

        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        $logger->expects($this->exactly(2))
            ->method('info')
            ->withConsecutive(
                [$this->isType('string'), $this->isType('array')],
                [$this->isType('string')]
            );

        $middleware = new LoggingMiddleware($logger);
        $response   = $middleware->process($request, $handler);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}

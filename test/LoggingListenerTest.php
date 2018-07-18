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

use Exception;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PHPUnit\Framework\TestCase;

class LoggingListenerTest extends TestCase
{
    public function testInstance()
    {
        $listener = new LoggingListener(
            $this->getMockForAbstractClass(LoggerInterface::class)
        );

        $this->assertInstanceOf(LoggingListenerInterface::class, $listener);
    }

    protected function getRequestObject($times)
    {
        $request = $this->getMockForAbstractClass(ServerRequestInterface::class);
        $request->expects($this->exactly($times))
            ->method('getMethod')
            ->will($this->returnValue('GET'));
        $request->expects($this->exactly($times))
            ->method('getUri')
            ->will($this->returnValue('test.test'));

        return $request;
    }

    protected function getResponseObject($times)
    {
        $response = $this->getMockForAbstractClass(ResponseInterface::class);
        $response->expects($this->exactly($times))
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        return $response;
    }

    protected function getObjectsWithoutPreviousException()
    {
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('error')
            ->with($this->isType('string'));

        $exception = new Exception('exception message', 123, null);

        return [$logger, $exception];
    }

    protected function getObjectsWithPreviousException()
    {
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        $logger->expects($this->exactly(2))
            ->method('error')
            ->with($this->isType('string'));

        $exception = new Exception('exception message', 123,
            new Exception('stacked exception', 456)
        );

        return [$logger, $exception];
    }

    public function testLoggingByCallingLogMethodWithoutPreviousException()
    {
        list($logger, $exception) = $this->getObjectsWithoutPreviousException();

        $listener = new LoggingListener($logger);
        $listener->log($exception, $this->getRequestObject(1), $this->getResponseObject(1));
    }

    public function testLoggingByInvokingObjectWithoutPreviousException()
    {
        list($logger, $exception) = $this->getObjectsWithoutPreviousException();

        $listener = new LoggingListener($logger);
        $listener($exception, $this->getRequestObject(1), $this->getResponseObject(1));
    }

    public function testLoggingByCallingLogMethodWithExceptionStack()
    {
        list($logger, $exception) = $this->getObjectsWithPreviousException();

        $listener = new LoggingListener($logger);
        $listener->log($exception, $this->getRequestObject(2), $this->getResponseObject(2));
    }

    public function testLoggingByInvokingObjectWithExceptionStack()
    {
        list($logger, $exception) = $this->getObjectsWithPreviousException();

        $exception = new Exception('exception message', 123,
            new Exception('stacked exception', 456)
        );

        $listener = new LoggingListener($logger);
        $listener($exception, $this->getRequestObject(2), $this->getResponseObject(2));
    }
}

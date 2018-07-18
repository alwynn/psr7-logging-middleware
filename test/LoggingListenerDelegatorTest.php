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
use PHPUnit\Framework\TestCase;
use Zend\Stratigility\Middleware\ErrorHandler;

class LoggingListenerDelegatorTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            LoggingListenerDelegatorInterface::class,
            new LoggingListenerDelegator()
        );
    }

    protected function prepareObjectsToTestDelegation()
    {
        $listener = $this->getMockForAbstractClass(LoggingListenerInterface::class);

        $container = $this->getMockForAbstractClass(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->with($this->equalTo(LoggingListenerInterface::class))
            ->will($this->returnValue($listener));

        /*
          Zend Stratigility team screwed up and made ErrorHandler class final without
          declaring an interface for additional methods introduced in the class thus making
          ErrorHandler not mockable ... :/
         */
        $callback = function () {
            return new ErrorHandler(function() {}, function () {});
        };

        $delegator = new LoggingListenerDelegator();

        return [
            $delegator,
            $container,
            $callback
        ];
    }

    public function testAttachingByCallingDelegateMethod()
    {
        list($delegator, $container, $callback) = $this->prepareObjectsToTestDelegation();

        $handler = $delegator->delegate($container, null, $callback);

        $this->assertInstanceOf(ErrorHandler::class, $handler);
    }

    public function testAttachingByInvokingObject()
    {
        list($delegator, $container, $callback) = $this->prepareObjectsToTestDelegation();

        $handler = $delegator($container, null, $callback);

        $this->assertInstanceOf(ErrorHandler::class, $handler);
    }
}

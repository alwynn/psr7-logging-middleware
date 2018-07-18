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

class LoggingListenerFactoryTest extends TestCase
{
    use SetUpContainerWithLoggerTrait;

    public function testInstance()
    {
        $this->assertInstanceOf(LoggingListenerFactoryInterface::class, new LoggingListenerFactory());
    }

    public function testMiddlewareCreationByCreateMethod()
    {
        $factory  = new LoggingListenerFactory();
        $listener = $factory->create($this->setupContainer());

        $this->assertInstanceOf(LoggingListenerInterface::class, $listener);
        $this->assertInstanceOf(LoggingListener::class, $listener);
    }

    public function testMiddlewareCreationByInvokingObject()
    {
        $factory  = new LoggingListenerFactory();
        $listener = $factory($this->setupContainer());

        $this->assertInstanceOf(LoggingListenerInterface::class, $listener);
        $this->assertInstanceOf(LoggingListener::class, $listener);
    }
}

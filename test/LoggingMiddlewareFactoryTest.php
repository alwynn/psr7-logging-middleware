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
use Psr\Http\Server\MiddlewareInterface;
use PHPUnit\Framework\TestCase;

class LoggingMiddlewareFactoryTest extends TestCase
{
    use SetUpContainerWithLoggerTrait;

    public function testInstance()
    {
        $this->assertInstanceOf(LoggingMiddlewareFactoryInterface::class, new LoggingMiddlewareFactory());
    }

    public function testMiddlewareCreationByCreateMethod()
    {
        $factory    = new LoggingMiddlewareFactory();
        $middleware = $factory->create($this->setupContainer());

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
        $this->assertInstanceOf(LoggingMiddleware::class, $middleware);
    }

    public function testMiddlewareCreationByInvokingObject()
    {
        $factory    = new LoggingMiddlewareFactory();
        $middleware = $factory($this->setupContainer());

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
        $this->assertInstanceOf(LoggingMiddleware::class, $middleware);
    }
}

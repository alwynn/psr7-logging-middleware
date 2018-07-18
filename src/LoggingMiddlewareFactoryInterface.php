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

use Psr\Container\ContainerInterface;

/**
 * Factory for creating middleware that logs requests and responses
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
interface LoggingMiddlewareFactoryInterface
{
    /**
     * Create a middleware.
     * Should call LoggingMiddlewareFactoryInterface::create(). Allows the factory to be
     * invoked as a callable.
     *
     * @param  ContainerInterface $container DI container
     * @return LoggingMiddleware
     */
    public function __invoke(ContainerInterface $container): LoggingMiddleware;

    /**
     * Creates a logging middleware.
     *
     * @param  ContainerInterface $container
     * @return LoggingMiddleware
     */
    public function create(ContainerInterface $container): LoggingMiddleware;
}

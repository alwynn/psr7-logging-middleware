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

/**
 * Factory for creating middleware that logs requests and responses
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
class LoggingMiddlewareFactory implements LoggingMiddlewareFactoryInterface
{
    /** @inheritdoc */
    public function __invoke(ContainerInterface $container): LoggingMiddleware
    {
        return $this->create($container);
    }

    /** @inheritdoc */
    public function create(ContainerInterface $container): LoggingMiddleware
    {
        return new LoggingMiddleware(
            $container->get(LoggerInterface::class)
        );
    }
}

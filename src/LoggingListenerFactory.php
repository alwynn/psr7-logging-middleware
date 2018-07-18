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
 * Factory for creating logging error handler listener
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
class LoggingListenerFactory implements LoggingListenerFactoryInterface
{
    /** @inheritdoc */
    public function __invoke(ContainerInterface $container): LoggingListener
    {
        return $this->create($container);
    }

    /** @inheritdoc */
    public function create(ContainerInterface $container): LoggingListener
    {
        return new LoggingListener(
            $container->get(LoggerInterface::class)
        );
    }
}

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
 * Factory for creating LoggingListenerFactoryInterface
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
interface LoggingListenerFactoryInterface
{
    /**
     * Create a listener.
     * Should call LoggingListenerFactoryInterface::create(). Allows the factory to be
     * invoked as a callable.
     *
     * @param  ContainerInterface $container DI container
     * @return LoggingListener
     */
    public function __invoke(ContainerInterface $container): LoggingListener;

    /**
     * Creates an error listener.
     *
     * @param  ContainerInterface $container
     * @return LoggingListener
     */
    public function create(ContainerInterface $container): LoggingListener;
}

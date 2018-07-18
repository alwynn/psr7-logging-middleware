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
use Zend\Stratigility\Middleware\ErrorHandler;

/**
 * Delegator that attaches logging listener to an error handler.
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
class LoggingListenerDelegator implements LoggingListenerDelegatorInterface
{
    /** @inheritdoc */
    public function __invoke(ContainerInterface $container, $service, callable $callback): ErrorHandler
    {
        return $this->delegate($container, $service, $callback);
    }

    /** @inheritdoc */
    public function delegate(ContainerInterface $container, $service, callable $callback): ErrorHandler
    {
        $listener = $this->getListener($container);
        $handler  = $callback();
        $handler->attachListener($listener);

        return $handler;
    }

    /**
     * Retrieves a listener instance from the container.
     * This function allows to extend the delegator and provide with custom
     * implementation of the listener.
     *
     * @param  ContainerInterface       $container DI container
     * @return LoggingListenerInterface            Logging error listener
     */
    protected function getListener(ContainerInterface $container): LoggingListenerInterface
    {
        return $container->get(LoggingListenerInterface::class);
    }
}

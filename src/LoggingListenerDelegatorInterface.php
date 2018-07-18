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
interface LoggingListenerDelegatorInterface
{
    /**
     * Attaches an error listener to the error handler.
     * Should call LoggingListenerDelegatorInterface::delegate(). Allows the delegator to be
     * invoked as a callable.
     *
     * @param  ContainerInterface $container
     * @param  mixed              $service
     * @param  callable           $callback
     * @return ErrorHandler
     */
    public function __invoke(ContainerInterface $container, $service, callable $callback): ErrorHandler;

    /**
     * Attaches an error listener to the error handler
     *
     * @param  ContainerInterface $container
     * @param  mixed              $service
     * @param  callable           $callback
     * @return ErrorHandler
     */
    public function delegate(ContainerInterface $container, $service, callable $callback): ErrorHandler;
}

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

use Zend\Stratigility\Middleware\ErrorHandler;

/**
 * Config provider for zend config aggregator.
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
class ZendConfigProvider
{
    /** @codeCoverageIgnore */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'delegators' => [
                    ErrorHandler::class => [
                        LoggingListenerDelegator::class
                    ]
                ],
                'invokables' => [
                    LoggingListenerDelegator::class => LoggingListenerDelegator::class
                ],
                'factories'  => [
                    LoggingListenerInterface::class => LoggingListenerFactory::class,
                    LoggingListener::class          => LoggingListenerFactory::class,
                    LoggingMiddleware::class        => LoggingMiddlewareFactory::class,
                ],
            ]
        ];
    }
}

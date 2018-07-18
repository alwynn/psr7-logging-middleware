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

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Error logging listener
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
interface LoggingListenerInterface
{

    /**
     * Logs an error with whole stack.
     * Should call LoggingListenerInterface::log(). Allows the listener to be
     * invoked as a callable.
     *
     * @param Throwable              $error
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     */
    public function __invoke(
        Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : void;

    /**
     * Logs an error with whole stack
     *
     * @param Throwable              $error
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     */
    public function log(
        Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : void;
}

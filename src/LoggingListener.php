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
final class LoggingListener implements LoggingListenerInterface
{
    use ContainsLoggerTrait;

    /** @inheritdoc */
    public function __invoke(
        Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): void {
        $this->log($error, $request, $response);
    }

    /** @inheritdoc */
    public function log(
        Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : void {

        $this->logger->error(sprintf(
            '%d [%s] %s: %s [%d] (%s:%d)',
            $response->getStatusCode(),
            $request->getMethod(),
            $request->getUri(),
            $error->getMessage(),
            $error->getCode(),
            $error->getFile(),
            $error->getLine()
        ));

        $previous = $error->getPrevious();

        if ($previous instanceof Throwable) {
            $this->log($previous, $request, $response);
        }
    }
}

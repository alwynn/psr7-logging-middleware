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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * PSR-7 logging middleware
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
final class LoggingMiddleware implements MiddlewareInterface
{
    use ContainsLoggerTrait;

    /**
     * @inheritdoc
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {

        $this->logger->info(
            sprintf(
                '[REQUEST] HTTP %s %s: uri: %s, length: %d',
                $request->getProtocolVersion(),
                $request->getMethod(),
                $request->getUri(),
                $request->getBody()->getSize()
            ),
            $request->getHeaders()
        );

        $response = $handler->handle($request);

        $this->logger->info(sprintf(
            '[RESPONSE] status %d, length: %d',
            $response->getStatusCode(),
            $response->getBody()->getSize()
        ));

        return $response;
    }
}

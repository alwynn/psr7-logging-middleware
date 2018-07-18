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

/**
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 */
trait ContainsLoggerTrait
{
    /** @var LoggerInterface */
    protected $logger;

    /** @param LoggerInterface $logger */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

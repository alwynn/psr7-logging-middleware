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

trait SetUpContainerWithLoggerTrait
{
    protected $container;

    public function setupContainer()
    {
        $logger    = $this->getMockForAbstractClass(LoggerInterface::class);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $container->expects($this->once())
            ->method('get')
            ->with($this->equalTo(LoggerInterface::class))
            ->will($this->returnValue($logger));

        return $container;
    }
}

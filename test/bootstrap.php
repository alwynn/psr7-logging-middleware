<?php declare(strict_types=1);
/**
 * PSR-7 logging middleware
 *
 * @author  Alwynn <alwynn.github@gmail.com>
 * @package alwynn/psr7-logging-middleware
 * @link    https://github.com/alwynn/psr7-logging-middleware
 * @license MIT
 */

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Psr7\\Middleware\\Logging\\', __DIR__);

return $loader;

<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */

namespace Slim\Interfaces;

use Slim\App;

interface RouteGroupInterface
{
    /**
     * Get router pattern
     *
     * @return string
     */
    public function getPattern();

    /**
     * Prepend middleware to the group middleware collection
     *
     * @param callable|string $callable The callback routine
     *
     * @return RouteGroupInterface
     */
    public function add($callable);

    /**
     * Execute router group callable in the context of the Slim App
     *
     * This method invokes the router group object's callable, collecting
     * nested router objects
     *
     * @param App $app
     */
    public function __invoke(App $app);
}

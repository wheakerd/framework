<?php
declare(strict_types=1);

namespace Wheakerd;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface, ArrayAccess
{

    

    public function get(string $id)
    {
        // TODO: Implement get() method.
    }

    public function has(string $id): bool
    {
        // TODO: Implement has() method.
    }
}
<?php

namespace Lime\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class LimeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

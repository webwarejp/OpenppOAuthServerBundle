<?php

namespace Openpp\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenppOAuthServerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSOAuthServerBundle';
    }

}

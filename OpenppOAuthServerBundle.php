<?php

namespace Openpp\OAuthServerBundle;

use Openpp\OAuthServerBundle\DependencyInjection\OpenppOAuthServerExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenppOAuthServerBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new OpenppOAuthServerExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSOAuthServerBundle';
    }
}

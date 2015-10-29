<?php

namespace Openpp\OAuthServerBundle;

use Openpp\OAuthServerBundle\DependencyInjection\OpenppOAuthServerExtension;
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

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new OpenppOAuthServerExtension();
        }
        return $this->extension;
    }
}

<?php

namespace Openpp\OAuthServerBundle\Entity;

use Openpp\OAuthServerBundle\Model\Client as AbstractedClient;
use OAuth2\OAuth2;

/**
 * Represents a Base Client Entity.
 */
class BaseClient extends AbstractedClient
{
    /**
     * Hook on pre-persist operations.
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Hook on pre-update operations.
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Check secret if client credential grant flow, set scope
     *
     * @param  $secret
     *
     * @return true || array('scope' => scope)
     */
    public function checkSecret($secret)
    {
        if (in_array(OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS, $this->getAllowedGrantTypes())) {
            return array(
                'scope' => 'API_USER'
            );
        }

        return (null === $this->secret || $secret === $this->secret);
    }
}

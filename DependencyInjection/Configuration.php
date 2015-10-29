<?php

namespace Openpp\OAuthServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('openpp_oauth_server');

        $rootNode
            ->children()
                ->scalarNode('client_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('access_token_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('refresh_token_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('auth_code_class')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}

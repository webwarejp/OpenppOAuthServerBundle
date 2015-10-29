<?php

namespace Openpp\OAuthServerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OpenppOAuthServerExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach($config as $key => $value)
        {
            $container->setParameter('openpp_oauth_server.'.$key, $value);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('openpp_oauth_server');

        $container->prependExtensionConfig('fos_oauth_server', $config[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'openpp_oauth_server';
    }
}

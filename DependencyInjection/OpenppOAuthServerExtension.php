<?php

namespace Openpp\OAuthServerBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
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

        $bundles = $container->getParameter('kernel.bundles');

        //$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$loader->load('services.yml');

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('admin.xml');
        }
        $loader->load('oauth.xml');

        foreach ($config as $key => $value)
        {
           $container->setParameter('openpp_oauth_server.'.$key, $value);
        }

        $this->registerDoctrineMapping($config);
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        // Many-To-One, Unidirectional for Client and AccessToken
        $collector->addAssociation($config['access_token_class'], 'mapManyToOne', array(
            'fieldName'     => 'client',
            'targetEntity'  => $config['client_class'],
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        // Many-To-One, Unidirectional for Client and RefreshToken
        $collector->addAssociation($config['refresh_token_class'], 'mapManyToOne', array(
            'fieldName'     => 'client',
            'targetEntity'  => $config['client_class'],
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        // Many-To-One, Unidirectional for Client and AuthCode
        $collector->addAssociation($config['auth_code_class'], 'mapManyToOne', array(
            'fieldName'     => 'client',
            'targetEntity'  => $config['client_class'],
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        // Many-To-One, Unidirectional for User and AuthCode
        $collector->addAssociation($config['access_token_class'], 'mapManyToOne', array(
            'fieldName'     => 'user',
            'targetEntity'  => 'Application\Sonata\UserBundle\Entity\User',
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        // Many-To-One, Unidirectional for User and AccessToken
        $collector->addAssociation($config['refresh_token_class'], 'mapManyToOne', array(
            'fieldName'     => 'user',
            'targetEntity'  => 'Application\Sonata\UserBundle\Entity\User',
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        // Many-To-One, Unidirectional for User and RefreshToken
        $collector->addAssociation($config['auth_code_class'], 'mapManyToOne', array(
            'fieldName'     => 'user',
            'targetEntity'  => 'Application\Sonata\UserBundle\Entity\User',
            'cascade'       => array(
                    1 => 'persist',
                ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface::prepend()
     */
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

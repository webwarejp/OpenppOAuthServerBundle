OpenppOAuthServerBundle
=======================

## Installation

1. Download OpenppOAuthServerBundle using composer
2. Enable the Bundles
3. Configure Dependency Bundles
4. Configure OpenppOAuthServerBundle
5. Extending OpenppOAuthServerBundle



### Step 1: Download OpenppOAuthServerBundle using composer

Require the bundle with composer:

``` bash
$ composer require openpp/oauth-server-bundle "0.1.*"
```

Composer will install the bundle to your project's ``vendor/openpp/oauth-server-bundle`` directory.

``` bash
$ composer require sonata-project/doctrine-orm-admin-bundle "2.3.*"
```

Composer will install the bundle to your project's ``vendor/sonata-project/doctrine-orm-admin-bundle`` directory.



### Step 2: Enable the bundles

Enable the bundle in the kernel::

``` php
// app/AppKernel.php
class AppKernel {
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),

            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),

            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),

            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),

            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),

            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new Openpp\OAuthServerBundle\OpenppOAuthServerBundle(),
            // ...
        );
    }
```



### Step 3. Configure Dependency Bundles

#### Configure the SonataCoreBundle

https://sonata-project.org/bundles/core/master/doc/reference/installation.html

#### Configure the SonataBlockBundle
https://sonata-project.org/bundles/block/master/doc/reference/installation.html

#### Configure the SonataAdminBundle with SonataDoctrineORMAdminBundle

https://sonata-project.org/bundles/doctrine-orm-admin/2-2/doc/reference/installation.html

https://sonata-project.org/bundles/admin/master/doc/getting_started/installation.html

#### Configure the SonataEasyExtendsBundle

https://sonata-project.org/bundles/easy-extends/master/doc/reference/installation.html

#### Configure the SonataUserBundle with FOSUserBundle

http://symfony.com/doc/current/bundles/FOSUserBundle/index.html

https://sonata-project.org/bundles/user/2-2/doc/reference/installation.html

``` php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new JMS\SerializerBundle\JMSSerializerBundle(),
    // ...
);
```

#### Configure the FOSRestServerBundle with JMSSerializerBundle

http://symfony.com/doc/master/bundles/FOSRestBundle/1-setting_up_the_bundle.html

http://jmsyst.com/bundles/JMSSerializerBundle

#### Configure the FOSOAuthServerBundle

https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md



### Step 4. Configure OpenppOAuthServerBundle

``` yaml
# app/config/config.yml
openpp_oauth_server:
    client_class:        Application\Openpp\OAuthServerBundle\Entity\Client
    access_token_class:  Application\Openpp\OAuthServerBundle\Entity\AccessToken
    refresh_token_class: Application\Openpp\OAuthServerBundle\Entity\RefreshToken
    auth_code_class:     Application\Openpp\OAuthServerBundle\Entity\AuthCode

sonata_admin:
    dashboard:
        groups:
            application_openpp_oauth_server.admin.client:
                label:           OAuth
                icon:            '<i class="fa fa-cogs"></i>'
                items:
                    - application_openpp_oauth_server.admin.client
```

``` yaml
# app/config/routing.yml
fos_oauth_server_security:
    resource: "@OpenppOAuthServerBundle/Resources/config/routing/security.xml"
    prefix:   /

openpp_api_oauth_user:
    resource: "@OpenppOAuthServerBundle/Resources/config/routing/api/user.xml"
    prefix:   /user
    type:     rest

openpp_api_oauth_verify:
    resource: "@OpenppOAuthServerBundle/Resources/config/routing/api/verify.xml"
    prefix:   /verify
    type:     rest
```

### Step 5. Extendig OpenppOAuthServerBundle

``` bash
$ php app/console sonata:easy-extends:generate OpenppOAuthServerBundle -d src
```

Enable the bundle in the kernel::

``` php
// app/AppKernel.php
class AppKernel {
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Application\Openpp\OAuthServerBundle\ApplicationOpenppOAuthServerBundle(),
            // ...
        );
    }
```

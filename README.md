OpenppOAuthServerBundle
=======================

Installation
------------

1. Download OpenppOAuthServerBundle using composer
2. Enable the Bundle
3. Create your model class
4. Configure your application's security.yml
5. Configure the FOSOAuthServerBundle

Step 1: Download FOSUserBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require openpp/oauth-server-bundle

Composer will install the bundle to your project's ``vendor/openpp/oauth-server-bundle`` directory.

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new Openpp\OAuthServerBundle\OpenppOAuthServerBundle(),
            // ...
        );
    }

Step 3: Create your User class
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
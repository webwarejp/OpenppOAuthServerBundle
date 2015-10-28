<?php

namespace Openpp\OAuthServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateClientCommand
 * @package Openpp\OAuthServerBundle\Command
 */
class CreateClientCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
        ->setName('openpp:oauth-server:client:create')
        ->setDescription('Creates a new client')
        ->addOption(
                'redirect-uri',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.',
                null
        )
        ->addOption(
                'grant-type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..',
                null
        )
        ->addOption(
            'private',
            null,
            InputOption::VALUE_REQUIRED,
            'Set private network client',
            false
        )
        ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Sets the client name. It is used for the display.',
                null
        )
        ->setHelp(
                <<<EOT
                    The <info>%command.name%</info>command creates a new client.

<info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>

EOT
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setName($input->getArgument('name'));
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setPrivate($input->getOption('private'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);
        $output->writeln(
                sprintf(
                        'Added a new client with public id <info>%s</info>, secret <info>%s</info>',
                        $client->getPublicId(),
                        $client->getSecret()
                )
        );
    }
}
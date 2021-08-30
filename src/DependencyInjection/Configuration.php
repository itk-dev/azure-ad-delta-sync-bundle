<?php

namespace ItkDev\AzureAdDeltaSyncBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('itk_dev_azure_ad_delta_sync');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('azure_ad_delta_sync_options')
                ->isRequired()
                    ->children()
                        ->scalarNode('tenant_id')
                            ->info('Tenant ID provided by authorizer')
                            ->cannotBeEmpty()->end()
                        ->scalarNode('client_id')
                            ->info('Client ID provided by authorizer')
                            ->cannotBeEmpty()->end()
                        ->scalarNode('client_secret')
                            ->info('Client secret/password provided by authorizer')
                            ->cannotBeEmpty()->end()
                        ->scalarNode('group_id')
                            ->info('Group ID provided by authorizer')
                            ->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('user_options')
                ->isRequired()
                    ->children()
                        ->scalarNode('user_class')
                            ->info('The User class name.')
                            ->cannotBeEmpty()->end()
                        ->scalarNode('user_property')
                            ->info('Unique user property.')
                            ->cannotBeEmpty()->end()
                        ->scalarNode('user_claim_property')
                            ->info('Azure user claim property.')
                            ->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

final class EzPlatformOmniboxExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependEzDesignConfiguration($container);
    }

    private function prependEzDesignConfiguration(ContainerBuilder $container): void
    {
        $eZDesignConfigFile = __DIR__ . '/../Resources/config/ezdesign.yaml';
        $config = Yaml::parseFile($eZDesignConfigFile);

        $container->prependExtensionConfig('ezdesign', $config['ezdesign']);
        $container->addResource(new FileResource($eZDesignConfigFile));
    }
}

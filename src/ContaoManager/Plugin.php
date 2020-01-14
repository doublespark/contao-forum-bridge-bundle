<?php

namespace Doublespark\ContaoForumBridgeBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Doublespark\ContaoForumBridgeBundle\ContaoForumBridgeBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class Plugin
 *
 * @package Doublespark\ContaoForumBridgeBundle\ContaoManager
 */
class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    /**
     * Load bundle
     * @param ParserInterface $parser
     * @return array
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoForumBridgeBundle::class)->setLoadAfter([ContaoCoreBundle::class])
        ];
    }

    /**
     * Provide custom routing
     * @param LoaderResolverInterface $resolver
     * @param KernelInterface $kernel
     * @return \Symfony\Component\Routing\RouteCollection|null
     * @throws \Exception
     */
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        $file = '@ContaoForumBridgeBundle/Resources/config/routing.yml';
        return $resolver->resolve($file)->load($file);
    }
}
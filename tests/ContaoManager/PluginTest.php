<?php

declare(strict_types=1);

namespace Doublespark\ContaoContaoForumBridgeBundle\Tests\ContaoManager;

use Doublespark\ContaoForumBridgeBundle\ContaoForumBridgeBundle;
use Doublespark\ContaoForumBridgeBundle\ContaoManager\Plugin;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class PluginTest extends \PHPUnit\Framework\TestCase {

    public function testReturnsTheBundles(): void
    {
        $parser = $this->createMock(ParserInterface::class);

        /** @var BundleConfig $config */
        $config = (new Plugin())->getBundles($parser)[0];

        $this->assertInstanceOf(BundleConfig::class, $config);
        $this->assertSame(ContaoForumBridgeBundle::class, $config->getName());
        $this->assertSame([ContaoCoreBundle::class], $config->getLoadAfter());
    }
}
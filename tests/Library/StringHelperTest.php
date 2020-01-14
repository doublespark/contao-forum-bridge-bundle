<?php

declare(strict_types=1);

namespace Doublespark\ContaoForumBridgeBundle\Tests\Library;

use Doublespark\ContaoForumBridgeBundle\Library\StringHelper;

class StringHelperTest extends \PHPUnit\Framework\TestCase {

    public function testUtf8Clean()
    {
        $arrTests = [
            'UserName'   => 'username',
            'user  name' => 'user name',
            'user@naMe'  => 'user@name'
        ];

        foreach($arrTests as $test => $expected)
        {
            $result = StringHelper::Utf8Clean($test);

            $this->assertEquals($expected,$result);
        }
    }
}
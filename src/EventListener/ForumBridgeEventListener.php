<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use Psr\Log\LogLevel;

/**
 * Class ForumBridgeEventListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
abstract class ForumBridgeEventListener
{
    /**
     * Log an error
     * @param $strText
     * @param $strFunction
     */
    protected function logError($strText, $strFunction)
    {
        $logger = System::getContainer()->get('monolog.logger.contao');
        $logger->log(LogLevel::ERROR, $strText, array('contao' => new ContaoContext($strFunction, 'ERROR')));
    }

    /**
     * Log a message
     * @param $strText
     * @param $strFunction
     */
    protected function logInfo($strText, $strFunction)
    {
        $logger = System::getContainer()->get('monolog.logger.contao');
        $logger->log(LogLevel::INFO, $strText, array('contao' => new ContaoContext($strFunction, 'GENERAL')));
    }
}
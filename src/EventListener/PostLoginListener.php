<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\User;

/**
 * Class PostLoginListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class PostLoginListener {

    /**
     * @param User $user
     */
    public function onPostLogin(User $user): void
    {
        
    }
}
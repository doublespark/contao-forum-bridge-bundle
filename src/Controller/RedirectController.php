<?php

namespace Doublespark\ContaoForumBridgeBundle\Controller;

use Contao\Config;
use Contao\PageModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RedirectController
 *
 * @package Doublespark\ContaoForumBridgeBundle\Controller
 */
class RedirectController extends AbstractController
{
    /**
     * Handle redirects from phpBB
     * @param $location
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function redirectAction($location, Request $request)
    {
        $arrValidLocations = ['login','account','logout','register'];

        if(!in_array($location, $arrValidLocations))
        {
            return Response::create('Not found',404);
        }

        switch($location)
        {
            case 'login':
                return $this->redirectToContaoPage(Config::get('phpbb_login_page'));

            case 'logout':
                return $this->redirectToContaoPage(Config::get('phpbb_logout_page'));

            case 'account':
                return $this->redirectToContaoPage(Config::get('phpbb_account_page'));

            case 'register':
                return $this->redirectToContaoPage(Config::get('phpbb_register_page'));
        }
    }

    /**
     * Redirects to a Contao page based on ID
     * @param $pageId
     * @return RedirectResponse
     * @throws \Exception
     */
    protected function redirectToContaoPage($pageId)
    {
        $objPage = PageModel::findByPk($pageId);

        if(!$objPage)
        {
            throw new \Exception('Redirect page not found. Ensure the redirect pages have been configured in the phpBB bridge settings.');
        }

        $alias = $objPage->alias;

        if($alias === 'index')
        {
            $alias = '';
        }

        return RedirectResponse::create('/'.$alias);
    }
}

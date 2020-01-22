<?php

declare(strict_types=1);

namespace Doublespark\ContaoContaoForumBridgeBundle\Tests\Controller;


use Doublespark\ContaoForumBridgeBundle\Controller\RedirectController;
use Doublespark\ContaoForumBridgeBundle\Facade\PageModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectControllerTest extends \PHPUnit\Framework\TestCase {

    public function testReturns404ResponseForNonValidRoutes(): void
    {
        $request = new Request();

        $mock = $this->createMock(PageModel::class);

        $controller = new RedirectController($mock);

        /**
         * @var Response
         */
        $response = $controller->redirectAction('notvalid',$request);

        $this->assertInstanceOf(Response::class,$response);
        $this->assertEquals(404,$response->getStatusCode());
    }

    public function testReturnsRedirectResponseForValidRoutes()
    {
        $request = new Request();

        $stub = $this->createStub(PageModel::class);

        $objPage = new \Contao\PageModel();
        $objPage->alias = 'login';

        $stub->method('findByPk')->willReturn($objPage);

        $controller = new RedirectController($stub);

        /**
         * @var Response
         */
        $response = $controller->redirectAction('login',$request);

        $this->assertInstanceOf(RedirectResponse::class,$response);

        $this->assertEquals($response->getTargetUrl(), '/login');
    }
}
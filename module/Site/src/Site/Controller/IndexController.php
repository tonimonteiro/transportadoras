<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function siteMapAction()
    {
    	return new ViewModel();
    }

    public function searchAction()
    {
        $keyword = $this->params()->fromQuery('q',null);

        if (! empty($keyword)) {

            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $repository = $entityManager->getRepository('SimCms\Entity\Cms');

            $criteria['title'] = 'a.title LIKE :title';
            $parameters['title'] = '%' . $keyword . '%';

            $criteria['content'] = 'a.content LIKE :content';
            $parameters['content'] = '%' . $keyword . '%';

            // state
            $parameters['state'] = 1;

            $query = $repository->createQueryBuilder('a');
            $query->where('(' . implode(' OR ', $criteria) . ') AND a.state = :state');
            $query->setParameters($parameters);

            /**
             * List data.
             */
            $list = $query->getQuery()->getResult();

            /**
             * Show data and pagination.
             */
            $page = $this->params()->fromRoute('page');

            $paginator = new Paginator(new ArrayAdapter($list));
            $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage(10);

            /**
             * Return.
             */
            return new ViewModel(array(
                'data' => $paginator,
                'page' => $page,
                'keyword' => $keyword,
            ));

        }

        /**
         * Return.
         */
        return new ViewModel(array(
            'data' => null,
            'page' => null,
            'keyword' => null,
        ));
    }

    public function pageAction()
    {
        $router = $this->params()->fromRoute();

        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $entityManager->getRepository('SimCms\Entity\Cms');

        $terminal = null;
        $template = 'page';
        $page = null;

        if ($router['id'] == 'pages') {

            $content = $repository->getList($router['navigation']);
            $navi = $content;
            switch (count($content)) {

                case 0:
                    $view = new ViewModel();
                    $view->setTemplate('error/404.phtml');
                    return $view;
                    break;
                case 1:
                    $content = $content[0];
                    $terminal = $content->getTerminal();
                    break;
                default:
                    $template = 'pages';

                    $page = $this->params()->fromQuery('page',null);

                    $content = new Paginator(new ArrayAdapter($content));
                    $content->setCurrentPageNumber($page)->setDefaultItemCountPerPage(10);

                    break;
            }

            // breadcrumb
            $path = $this->Path($navi[0]->getNavigation());
            $nameGroup = $navi[0]->getNavigation()->getNameGroup();
        } else {

            $content = $repository->findOneById($router['id']);

            /**
             * Page state disabled.
             */
            if ($content->getState() == 2) {
                $this->redirect()->toUrl('/404');
            }

            // breadcrumb
            $path = $this->Path($content->getNavigation());
            $nameGroup = $content->getNavigation()->getNameGroup();

            $terminal = $content->getTerminal();
        }

        $view = new ViewModel(array(
            'data' => $content,
            'page' => $page,
            'id' => $router['id'],
            'breadcrumb' => $path['breadcrumb'],
            'nameGroup' => $nameGroup
        ));

        if (! empty($terminal)) {
            $view->setTerminal(true);
            $view->setTemplate('site/index/' . $router['navigation'] . '.phtml');
        } else {
            $view->setTemplate('site/index/' . $template . '.phtml');
        }

        return $view;
    }

}

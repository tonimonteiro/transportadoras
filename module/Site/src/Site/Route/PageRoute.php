<?php
namespace Site\Route;

use Zend\Mvc\Router\Http\RouteInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Stdlib\ArrayUtils;

class PageRoute implements RouteInterface, ServiceManagerAwareInterface
{

    protected $serviceManager;

    protected $defaults;

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    public function __construct(array $defaults = array())
    {
        $this->defaults = $defaults;
    }

    public static function factory($options = array())
    {
        if ($options instanceof \Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (! is_array($options)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (! isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        return new static($options['defaults']);
    }

    public function match(Request $request)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        $pathSearch = str_replace("/", "", str_replace("-", "", $path));

        $entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        $repository = $entityManager->getRepository('SimCms\Entity\Cms');
        $page = $repository->findOneByUrlIndex($pathSearch);

        if ($page) {
            $params = $this->defaults;
            $params['id'] = $page->getId();

            return new RouteMatch($params);

        } else {
            $pages = $repository->findOneByNavigationName($pathSearch);

            if ($pages) {
                $params = $this->defaults;
                $params['navigation'] = $pathSearch;

                return new RouteMatch($params);

            }
        }

        return null;
    }

    public function assemble(array $params = array(), array $options = array())
    {
        return !empty($this->route) ? $this->route : '';
    }

    public function getAssembledParams()
    {
        return array();
    }
}
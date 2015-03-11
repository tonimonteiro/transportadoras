<?php
namespace SimNavigation\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class DefaultNavigation extends DefaultNavigationFactory
{

    protected $navigation;

    protected $root;

    protected $criteria = array();

    /**
     *
     * @param string $navigation
     */
    public function __construct($navigation = '', $root = 1)
    {
        $this->navigation = $navigation;
        $this->root = $root;
    }

    /**
     * Gets the $criteria.
     *
     * @return field_type
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

	/**
     * Sets the $criteria.
     *
     * @param array $criteria
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

	protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {

            $criteria = array(
                'parent' => $this->root,
                'nameGroup' => $this->navigation,
                'active' => 1,
            );

            if (count($this->getCriteria()) > 0) {
                foreach ($this->getCriteria() as $field => $value) {
                    $criteria[$field] = $value;
                }
            }

            $service = $serviceLocator->get('SimNavigation\Service\Navigation');
            $list = $service->getEntityManager()
                            ->getRepository($service->getEntity())
                            ->findByParentRecursive($criteria);

            $configuration[$this->navigation][$this->getName()] = $list;

            if (! isset($configuration[$this->navigation])) {
                throw new \Exception('Could not find navigation configuration key');
            }
            if (! isset($configuration[$this->navigation][$this->getName()])) {
                throw new \Exception(sprintf('Failed to find a navigation container by the name "%s"', $this->getName()));
            }

            $application = $serviceLocator->get('application');
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $router = $application->getMvcEvent()->getRouter();
            $pages = $this->getPagesFromConfig($configuration[$this->navigation][$this->getName()]);

            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
    }
}
<?php
namespace SimCms\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Path extends AbstractPlugin
{

    private $list = array();

    /**
     *
     * @param string $navigation
     * @throws \Exception
     * @return multitype:
     */
    public function __invoke($navigation = null)
    {
        try {
            if ($navigation) {
                $this->getParent($navigation);

                $this->list['url'] = $this->getUrl();
                $this->list['breadcrumb'] = array_reverse($this->list['breadcrumb'], true);

                return $this->list;
            } else {
                throw new \Exception('Invalid navigation.');
            }
        } catch (\Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }

    /**
     *
     * @return string
     */
    private function getUrl()
    {
        $url = array_reverse($this->list['url'], true);
        return '/' . implode('/', $url) . '/';
    }

    /**
     *
     * @param string $parent
     */
    private function getParent($parent = null)
    {
        $urlCustom = new UrlCustom();

        $this->list['url'][$parent->getId()] = $urlCustom->friendly($parent->getLabel());
        $this->list['breadcrumb'][$parent->getId()] = array('label' => $parent->getLabel(),
                                                            'uri' => $parent->getUri());

        if (($parent->getParent()->getParent())) {
            if ($parent->getParent()->getParent()->getId() > 1) {
                $this->list['url'][$parent->getParent()->getId()] = $urlCustom->friendly($parent->getParent()
                    ->getLabel());
                $this->list['breadcrumb'][$parent->getParent()->getId()] = array('label' => $parent->getParent()->getLabel(),
                                                                                 'uri' => $parent->getParent()->getUri());
                $this->getParent($parent->getParent());
            }
        }
    }
}
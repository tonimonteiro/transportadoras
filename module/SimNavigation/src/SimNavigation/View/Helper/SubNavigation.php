<?php
namespace SimNavigation\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SubNavigation extends AbstractHelper
{

    public function __invoke($page, $ulClass = '')
    {
        $html = '<ul class="dropdown-menu ' . $ulClass . '">';

        foreach ($page->getPages() as $child) {

            /* @var $child Zend\Navigation\Page\Mvc */

            if ($child->hasPages()) {

                $click = 'onclick="document.location=\'' . $child->getHref() . '\'"';
                $html .= '<li class="dropdown-submenu' . ($child->isActive() ? ' active' : '') . ' ' . $child->getTitle() . '">';
                $html .= '<a class="dropdown-toggle" data-toggle="dropdown" ' . $click . ' href="' . $child->getHref() . ($child->getTarget() != "" ? 'target="' . $child->getTarget() : '') . '">';

                if (! empty($child->get("icon"))) {
                    $html .= '<span class="' . $child->get("icon") . '"></span>';
                }

                $html .= $child->getLabel();
                $html .= '</a>';

                $html .= $this->__invoke($child);
            } else {

                $html .= '<li class="' . ($child->isActive() ? ' active' : '') . '">';
                $html .= '<a href="' . $child->getHref() . ($child->getTarget() != "" ? 'target="' . $child->getTarget() : '') . '">';

                if (! empty($child->get("icon"))) {
                    $html .= '<span class="' . $child->get("icon") . '"></span>';
                }

                $html .= $child->getLabel();
                $html .= '</a>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }
}
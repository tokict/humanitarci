<?php

namespace Terranet\Administrator\Navigation\Presenters\Bootstrap;

use Pingpong\Menus\Presenters\Presenter;

class SidebarMenuPresenter extends Presenter
{
    /**
     * Get open tag wrapper.
     *
     * @return string
     */
    public function getOpenTagWrapper()
    {
        return '';
        return '<ul class="nav metismenu" id="side-menu">';

    }

    /**
     * Get close tag wrapper.
     *
     * @return string
     */
    public function getCloseTagWrapper()
    {
        return '';
        return '</ul>';
    }

    /**
     * Get menu tag without dropdown wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li'.$this->getActiveState($item).'>'.
                    '<a href="'.$item->getUrl().'" '.$item->getAttributes().'>'.
                        $item->getIcon().' <span>'.$item->title.'</span>'.
                    '</a>'.
                '</li>'.PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getActiveState($item, $state = ' class="active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * {@inheritdoc}.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="dropdown-header">'.$item->title.'</li>';
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return $this->getMenuWithDropDownWrapper($item);
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $key = str_random();

        return '
		<li class="'.$this->getActiveStateOnChild($item).'">
			<a href="#'.$key.'">
				'.$item->getIcon().' <span>'.$item->title.'</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
            <ul class="nav nav-second-level">
                '.$this->getChildMenuItems($item).'
            </ul>
		</li>
		'.PHP_EOL;
    }

    /**
     * Get active state on child items.
     *
     * @param        $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }
}

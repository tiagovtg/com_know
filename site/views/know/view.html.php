<?php
/**
 * @package     Know
 * @subpackage  com_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * HTML Know View class for the know component
 *
 * @static
 * @package     Know
 * @subpackage  com_know
 * @since       2.5
 */
class KnowViewKnow extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $print;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  JError object on failure, void on success.
	 *
	 * @since   2.5
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$user  = JFactory::getUser();
		$dispatcher = JDispatcher::getInstance();

		// Get view related request variables.
		$print = JRequest::getBool('print');

		// Get model data.
		$state = $this->get('State');
		$item  = $this->get('Item');

		if ($item)
		{
			// Get Category Model data
			$categoryModel = JModelLegacy::getInstance('Category', 'KnowModel', array('ignore_request' => true));
			$categoryModel->setState('category.id', $item->catid);
			$categoryModel->setState('list.ordering', 'a.name');
			$categoryModel->setState('list.direction', 'asc');

			$items = $categoryModel->getItems();
		}

		// Check for errors.
		// @TODO Maybe this could go into JComponentHelper::raiseErrors($this->get('Errors'))
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));

			return false;
		}

		// Add router helpers.
		$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
		$item->catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;
		$item->parent_slug = $item->category_alias ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

		// Check if cache directory is writeable
		$cacheDir = JPATH_CACHE . '/';

		if (!is_writable($cacheDir))
		{
			JError::raiseNotice('0', JText::_('COM_KNOW_CACHE_DIRECTORY_UNWRITABLE'));

			return;
		}

		// Merge know params. If this is single-know view, menu params override know params
		// Otherwise, know params override menu item params
		$params = $state->get('params');
		$know_params = clone $item->params;
		$active = $app->getMenu()->getActive();
		$temp = clone ($params);

		// Check to see which parameters should take priority
		if ($active)
		{
			$currentLink = $active->link;

			// If the current view is the active item and an know view for this know, then the menu item params take priority
			if (strpos($currentLink, 'view=know') && (strpos($currentLink, '&id=' . (string) $item->id)))
			{
				// $item->params are the know params, $temp are the menu item params
				// Merge so that the menu item params take priority
				$know_params->merge($temp);
				$item->params = $know_params;

				// Load layout from active query (in case it is an alternative menu item)
				if (isset($active->query['layout']))
				{
					$this->setLayout($active->query['layout']);
				}
			}
			else
			{
				// Current view is not a single know, so the know params take priority here
				// Merge the menu item params with the know params so that the know params take priority
				$temp->merge($know_params);
				$item->params = $temp;

				// Check for alternative layouts (since we are not in a single-know menu item)
				if ($layout = $item->params->get('know_layout'))
				{
					$this->setLayout($layout);
				}
			}
		}
		else
		{
			// Merge so that know params take priority
			$temp->merge($know_params);
			$item->params = $temp;

			// Check for alternative layouts (since we are not in a single-know menu item)
			if ($layout = $item->params->get('know_layout'))
			{
				$this->setLayout($layout);
			}
		}

		$offset = $state->get('list.offset');

		// Check the access to the know
		$levels = $user->getAuthorisedViewLevels();

		if (!in_array($item->access, $levels) or ((in_array($item->access, $levels) and (!in_array($item->category_access, $levels)))))
		{
			JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));

			return;
		}

		// Get the current menu item
		$menus  = $app->getMenu();
		$menu   = $menus->getActive();
		$params = $app->getParams();

		// Get the know
		$know = $item;

		$temp   = new JRegistry;
		$temp->loadString($item->params);
		$params->merge($temp);

		// Increment the hit counter of the know.
		if ($offset == 0)
		{
			$model = $this->getModel();
			$model->hit();
		}

		// Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->assignRef('params', $params);
		$this->assignRef('know', $know);
		$this->assignRef('state', $state);
		$this->assignRef('item', $item);
		$this->assignRef('user', $user);
		$this->print = $print;

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected function _prepareDocument()
	{
		$app     = JFactory::getApplication();
		$menus   = $app->getMenu();
		$pathway = $app->getPathway();
		$title   = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_KNOW_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		$id = (int) @$menu->query['id'];

		// If the menu item does not concern this know
		if ($menu && ($menu->query['option'] != 'com_know' || $menu->query['view'] != 'know' || $id != $this->item->id))
		{
			// If this is not a single know menu item, set the page title to the know title
			if ($this->item->name)
			{
				$title = $this->item->name;
			}

			$path = array(array('title' => $this->item->name, 'link' => ''));
			$category = JCategories::getInstance('Know')->get($this->item->catid);

			while (($menu->query['option'] != 'com_know' || $menu->query['view'] == 'know' || $id != $category->id) && $category->id > 1)
			{
				$path[] = array('title' => $category->title, 'link' => KnowHelperRoute::getCategoryRoute($category->id));
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach ($path as $item)
			{
				$pathway->addItem($item['title'], $item['link']);
			}
		}

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		if (empty($title))
		{
			$title = $this->item->name;
		}
		$this->document->setTitle($title);

		if ($this->item->metadesc)
		{
			$this->document->setDescription($this->item->metadesc);
		}
		elseif (!$this->item->metadesc && $this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->item->metakey)
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
		elseif (!$this->item->metakey && $this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}

		if ($app->getCfg('MetaTitle') == '1')
		{
			$this->document->setMetaData('title', $this->item->name);
		}

		if ($app->getCfg('MetaAuthor') == '1')
		{
			$this->document->setMetaData('author', $this->item->author);
		}

		$mdata = $this->item->metadata->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v)
			{
				$this->document->setMetadata($k, $v);
			}
		}
	}
}

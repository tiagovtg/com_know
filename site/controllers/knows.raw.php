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
 * Knows RAW controller for Know.
 *
 * @package     Know
 * @subpackage  com_know
 * @since       2.5
 */
class KnowControllerKnows extends JControllerLegacy
{
	/**
	 * Method to find search query knows.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function display()
	{
		$items = array();

		// Get the knows.
		$model = $this->getModel('Knows', 'KnowModel', array('ignore_request' => true));
		$model->setState('filter.search', JRequest::getVar('s'));
		$model->setState('list.ordering', 'a.created');
		$model->setState('list.direction', 'desc');
		$model->setState('filter.published', 1);
		$model->setState('list.limit', 5);

		$items = $model->getItems();

		$html = '<ul id="search-result">';

		// Check the data.
		if (!empty($items))
		{
			foreach ($items as $item)
			{

				// Add router helpers.
				$item->slug    = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
				$item->catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;

				$html .= '<li><a href="' . JRoute::_(KnowHelperRoute::getKnowRoute($item->slug, $item->catslug)) . '"><img src="templates/know/images/icon-article-s.png">' . $item->name . '</a></li>';
			}
		}
		else
		{
			$html .= 'Desculpe, não foram encontradas registros.';
		}

		$html .= '</ul>';

		// Send the response.
		echo $html;

		JFactory::getApplication()->close();
	}
}

<?php
/**
 * @package     Know_Categories
 * @subpackage  mod_know_categories
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_know/helpers/route.php';

jimport('joomla.application.categories');

/**
 * Know Categories module helper.
 *
 * @package     Know
 * @subpackage  mod_knowcategories
 * @since       2.5
 */
abstract class modKnowCategoriesHelper
{
	/**
	 * Get a list of the category items.
	 *
	 * @param   JRegistry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   2.5
	 */
	public static function getList(&$params)
	{
		$categories = JCategories::getInstance('Know');
		$category = $categories->get($params->get('parent', 'root'));

		if ($category != null)
		{
			$items = $category->getChildren();

			return $items;
		}
	}
}

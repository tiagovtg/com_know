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
 * Know component helper.
 *
 * @package     Know
 * @subpackage  com_know
 * @since       2.5
 */
class KnowHelper
{
	public static $extension = 'com_know';

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
     *
	 * @since   2.5
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_KNOW_SUBMENU_KNOWS'),
			'index.php?option=com_know&view=knows',
			$vName == 'knows'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_KNOW_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_know',
			$vName == 'categories'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 *
	 * @since   2.5
	 */
	public static function getActions()
	{
		$user      = JFactory::getUser();
		$result    = new JObject;
		$assetName = 'com_know';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

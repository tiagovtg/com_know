<?php
/**
 * @package     Know
 * @subpackage  com_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Know Component Controller
 *
 * @package     Know
 * @subpackage  com_know
 * @since       2.5
 */
class KnowController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	2.5
	 */
	protected $default_view = 'knows';

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached.
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController  This object to support chaining.
     *
	 * @since   2.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/know.php';

		// Load the submenu.
		KnowHelper::addSubmenu(JRequest::getCmd('view', 'knows'));

		$view   = JRequest::getCmd('view', 'knows');
		$layout = JRequest::getCmd('layout', 'default');
		$id     = JRequest::getInt('id');

		parent::display();

		return $this;
	}
}

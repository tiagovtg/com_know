<?php
/**
 * @package     Know
 * @subpackage  com_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Know Component Category Tree
 *
 * @static
 * @package     Know
 * @subpackage  com_know
 *
 * @since       2.5
 */
class KnowCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   2.5
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__know';
		$options['extension'] = 'com_know';
		$options['statefield'] = 'published';
		$options['countItems'] = 1;

		parent::__construct($options);
	}
}

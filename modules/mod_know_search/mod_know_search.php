<?php
/**
 * @package     Know
 * @subpackage  mod_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

//$list = modKnowSearchHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$text = htmlspecialchars($params->get('text'));
$button_text = htmlspecialchars($params->get('button_text'));

require JModuleHelper::getLayoutPath('mod_know_search', $params->get('layout', 'default'));

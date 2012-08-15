<?php
/**
 * @package     Know
 * @subpackage  com_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.module.helper');
?>
<article>
	<div id="know-header">
		<h1><?php echo htmlspecialchars($this->item->name); ?></h1>
		<?php $module = JModuleHelper::getModule('mod_breadcrumbs'); ?>
		<?php echo JModuleHelper::renderModule($module); ?>
	</div>
	<div class="know-content">
		<?php echo $this->item->description; ?>
	</div>
</article>

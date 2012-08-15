<?php
/**
 * @package     Know_Categories
 * @subpackage  mod_know_categories
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<ul>
	<?php foreach ($list as $item) : ?>
	<li>
		<span><?php echo htmlspecialchars($item->numitems); ?></span>
		<a href="<?php echo JRoute::_(KnowHelperRoute::getCategoryRoute($item->id)); ?>"><?php echo htmlspecialchars($item->title); ?></a>
	</li>
	<?php endforeach ?>
</ul>
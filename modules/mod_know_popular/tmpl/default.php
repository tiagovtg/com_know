<?php
/**
 * @package     Know_Popular
 * @subpackage  mod_know_popular
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<ul class="know-popular<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) : ?>
	<li class="standard">
		<h5>
			<a href="<?php echo $item->link; ?>"><?php echo htmlspecialchars($item->name); ?></a>
		</h5>
	</li>
	<?php endforeach; ?>
</ul>

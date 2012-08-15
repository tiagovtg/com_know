<?php
/**
 * @package     Know
 * @subpackage  com_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div class="know-categories">
	<h1>Categorias</h1>
	<?php $groups = array_chunk($this->items[$this->parent->id], 2); ?>
	<?php foreach ($groups as $group) : ?>
	<div class="row">
		<?php foreach($group as $id => $item) : ?>
		<div class="six columns <?php echo ($id % 2) ? 'omega' : 'alpha'; ?>">
			<h2>
				<a href="<?php echo JRoute::_(KnowHelperRoute::getCategoryRoute($item->id)); ?>"><?php echo $this->escape($item->title); ?></a>
				<span class="count">(<?php echo $item->numitems; ?>)</span>
			</h2>
			<ul>
				<?php foreach ($item->knows as $know): ?>
				<li>
					<a href="<?php echo JRoute::_(KnowHelperRoute::getKnowRoute($know->slug, $know->catslug)); ?>"><?php echo $this->escape($know->name); ?></a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endforeach; ?>
</div>

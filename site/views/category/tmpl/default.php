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
<div id="know-header">
	<h1>Categoria: <span><?php echo $this->escape($this->category->title); ?></span></h1>
	<?php if ($this->category->description): ?>
	<p><?php echo strip_tags($this->category->description); ?></p>
	<?php endif ?>
</div>
<?php foreach ($this->items as $item): ?>
<article class="post">
	<h2 class="know-title"><a href="<?php echo JRoute::_(KnowHelperRoute::getKnowRoute($item->slug, $item->catslug)); ?>" rel="bookmark"><?php echo $this->escape($item->name); ?></a></h2>
	<div class="know-content">
		<?php echo strip_tags($item->description); ?>
	</div>
	<a class="readmore" href="<?php echo JRoute::_(KnowHelperRoute::getKnowRoute($item->slug, $item->catslug)); ?>">Leia Mais <span>→</span></a>
</article>
<?php endforeach ?>

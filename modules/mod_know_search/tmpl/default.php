<?php
/**
 * @package     Know
 * @subpackage  mod_know
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div id="search-wrap">
	<form method="get" id="searchform" class="clearfix" action="#" autocomplete="off">
		<input type="text" onfocus="if (this.value == '<?php echo $text ? $text : JText::_('MOD_KNOW_SEARCH_TEXT'); ?>') {this.value = '';}" onblur="if (this.value == '')  {this.value = '<?php echo $text ? $text : JText::_('MOD_KNOW_SEARCH_TEXT'); ?>';}" value="<?php echo $text ? $text : JText::_('MOD_KNOW_SEARCH_TEXT'); ?>" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="<?php echo $button_text ? $button_text : JText::_('MOD_KNOW_SEARCH_SEARCH'); ?>" />
		<div class="ajax-loading"></div>
	</form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('#s').liveSearch({
			ajaxURL: 'index.php?option=com_know&task=knows.display&format=raw&tmpl=component&s='
		});
	});
</script>
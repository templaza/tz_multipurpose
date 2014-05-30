<?php
/*------------------------------------------------------------------------

# TZ Portfolio Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
//$saveOrder	= $listOrder == 'a.ordering';
?>

<form id="adminForm" name="adminForm" method="post" action="index.php?option=com_tz_multipurpose&view=groups">
    <?php if(!empty($this -> sidebar) AND COM_TZ_MULTIPURPOSE_JVERSION_COMPARE):?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this -> sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php else:?>
        <div id="j-main-container">
            <?php endif;?>
    <fieldset id="filter-bar">
        <div class="filter-search btn-group pull-left">
            <label class="element-invisible" for="search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search"
                   value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
                   title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
        </div>
        <div class="btn-group pull-left">
            <button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
            <button onclick="document.getElementById('search').value='';this.form.submit();"
                    type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" >
                <i class="icon-remove"></i>
            </button>
        </div>
    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
        <tr>
            <th width="1%">
                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
            <th>
                <?php echo JHtml::_('grid.sort', 'COM_MULTIPURPOSE_NAME', 'name', $listDirn, $listOrder); ?>
            </th>
            <th width="5%">
                <?php echo JHtml::_('grid.sort', 'COM_MULTIPURPOSE_ID', 'id', $listDirn, $listOrder); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="15">
                <?php //echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if($this -> item):?>
            <?php foreach($this -> item as $i => $item):?>

                <tr class="tz_multi_row">
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td>
                        <a href="index.php?option=com_tz_multipurpose&view=group&layout=edit&id=<?php echo $item -> id;?>">
                            <?php echo $item -> name;?>
                        </a>
                    </td>
                    <td>
                        <?php echo $item-> id; ?>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
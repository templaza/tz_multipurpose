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

defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

?>

<script type="text/javascript">
    Joomla.submitbutton = function(task) {
        if (task == 'group.cancel' || document.formvalidator.isValid(document.id('group-form'))){
            Joomla.submitform(task, document.getElementById('group-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
        }
    }
</script>

<form name="adminForm" method="post" class="form-validate row-fluid" id="group-form"
      action="index.php?option=com_tz_multipurpose&view=group&layout=edit&id=<?php echo $this -> item -> id?>">

    <div class="span12 form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_TZ_MULTIPURPOSE_DETAILS');?></legend>
            <div class="control-group">
                <div class="control-label">
                    <label width="100" for="jform_name" class="hasTip"
                           title="<?php echo JText::_('COM_TZ_MULTIPURPOSE_NAME')?>::<?php echo JText::_('COM_TZ_MULTIPURPOSE_NAME')?>">
                        <?php echo JText::_('COM_TZ_MULTIPURPOSE_NAME');?>
                        <span class="star"> *</span>
                    </label>
                </div>
                <div class="controls">
                    <input type="text"
                           maxlength="50"
                           size="50" class="inputbox required"
                           required="required"
                           value="<?php echo $this -> item -> name?>"
                           id="jform_name"
                           name="jform[name]">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label for="jform_id"
                           title="<?php echo JText::_('JGLOBAL_FIELD_ID_LABEL');?>::<?php echo JText::_('JGLOBAL_FIELD_ID_DESC')?>">
                        <?php echo JText::_('JGLOBAL_FIELD_ID_LABEL');?></label>
                </div>
                <div class="controls">
                    <input type="text" id="jform_id"
                           readonly="readonly" class="readonly"
                           value="<?php echo ($id = $this -> item -> id)?$id:0?>" name="jform[id]">
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <label width="100" for="jform_address" class="hasTip"
                           title="<?php echo JText::_('COM_TZ_MULTIPURPOSE_DESC')?>::<?php echo JText::_('COM_TZ_MULTIPURPOSE_DESC')?>">
                        <?php echo JText::_('COM_TZ_MULTIPURPOSE_DESC');?>
                    </label>
                </div>
                <div class="controls">
                    <textarea
                           cols="5"
                           row="10"
                           value="<?php echo $this -> item -> description?>"
                           id="jform_description"
                           name="jform[description]"
                           class=""><?php echo $this -> item -> description?></textarea>
                </div>
            </div>
        </fieldset>

    </div>
    <div class="clr"></div>

    <input type="hidden" value="com_tz_multipurpose" name="option">
    <input type="hidden" value="" name="task">
    <?php echo JHTML::_('form.token');?>
</form>
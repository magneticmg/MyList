<?php

/*==========================================================================*\
 || ######################################################################## ||
 || # MMInc PHP                                                            # ||
 || # Project: MyList                                             # ||
 || #  $Id:  $                                                             # ||
 || # $Date:  $                                                            # ||
 || # $Author:  $                                                          # ||
 || # $Rev: $                                                              # ||
 || # -------------------------------------------------------------------- # ||
 || # @Copyright (C) 2010 - Cameron Barr, Magnetic Merchandising Inc.      # ||
 || # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html                # ||
 || # -------------------------------------------------------------------- # ||
 || # http://www.magneticmerchandising.com  info@magneticmerchandising.com # ||
 ||                                                                          ||
 || # -------------------------------------------------------------------- # ||
 || ######################################################################## ||
 \*==========================================================================*/

?>
<form id="form" name="form">
<?php 
$fields = $this->form->getFieldSet('item');
 foreach ($fields as $field): ?>
    <div class="field_block">
        <div class="field_label"><?php echo $field->label; ?></div>      
        <div class="field_input"><?php echo $field->input; ?></div>      
    </div>
  <?php  endforeach; ?>
    <input name="task" value="item.save" type="hidden" />
    <input type="submit" value="Update" id="submit" />
</form>

<script>
    
               

</script>

<?php
/* ==========================================================================*\
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
  \*========================================================================== */
?>
<form name="<?php echo $this->form->getControlName() ;?>">
<?php 
$fields = $this->form->getFieldSet('item');
 foreach ($fields as $field): ?> 
    <div class="field_label"><?php echo $field->label; ?></div>      
    <div class="field_input"><?php echo $field->input; ?></div>      
  <?php  endforeach; ?>
</form>
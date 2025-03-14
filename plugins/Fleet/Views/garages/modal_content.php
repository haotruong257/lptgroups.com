<input type="hidden" name="id">
<?php echo render_input('name', 'name', '', 'text', ['required' => true]); ?>
<?php echo render_textarea( 'address', 'client_address','', array('rows' => 7)); ?>
<?php echo render_input( 'city', 'client_city'); ?>
<?php echo render_input( 'state', 'client_state'); ?>

<?php echo render_input( 'zip', 'client_postal_code'); ?>
<?php echo render_input( 'country', 'country'); ?>
<?php echo render_textarea('notes','notes') ?>

<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="<?php echo site_url('fleet_client/booking'); ?>" class="btn btn-default mbot15"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('booking'); ?></a>
          </div>
          </div>
        <div class="card-body">
        <table class="table table-booking scroll-responsive">
         <thead>
            <tr>
               <th><?php echo _l('booking_number'); ?></th>
               <th><?php echo _l('subject'); ?></th>
               <th><?php echo _l('delivery_date'); ?></th>
               <th><?php echo _l('amount'); ?></th>
               <th><?php echo _l('status'); ?></th>
               <th><?php echo _l('invoice'); ?></th>
            </tr>
         </thead>
         <tbody></tbody>
         <tfoot>
            <?php 
            $total = 0;
            $total_booking = 0;
            foreach($bookings as $booking){ ?>
               <tr>
                  <td><a href="<?php echo site_url('fleet_client/booking_detail/' . $booking['id']); ?>" class="invoice-number"><?php echo new_html_entity_decode($booking['number']); ?></a></td>
                  <td><?php echo new_html_entity_decode($booking['subject']); ?></td>
                  <td><?php echo _d($booking['delivery_date']); ?></td>
                  <td><?php 
                     $total_booking += $booking['amount'];
                     echo to_currency($booking['amount'], $currency); ?></td>
                    <td>
                     <?php echo fleet_render_status_html($booking['id'], 'booking', $booking['status']); ?>
                    </td>
                  <td><a href="<?php echo site_url('invoice/' . $booking['invoice_id'] . '/' . $booking['invoice_hash']); ?>" class="invoice-number"><?php echo get_invoice_id($booking['invoice_id']); ?></a></td>
               </tr>
            <?php } ?>
            <tr>
               <td><?php echo _l('total'); ?></td>
               <td></td>
               <td></td>
               <td class="total_booking"><?php echo to_currency($total_booking, $currency); ?></td>
               <td></td>
               <td></td>
            </tr>
         </tfoot>
      </table>
    </div>
</div>
</div>

<?php require 'plugins/Fleet/assets/js/client/booking_manage_js.php'; ?>

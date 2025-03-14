<div id="page-content" class="page-wrapper clearfix">

    <?php echo form_hidden('site_url', get_uri()); 
$status = fleet_render_status_html($booking->id, 'booking', $booking->status, false);   

    ?>
    <div class="card">
        <div class="card-body">

		<h4 class="invoice-html-status mtop7">
		</h4>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane ptop10 active" id="tab_estimate">
			<h4 class="h4-color"><?php echo _l('general_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                    <?php echo form_hidden('_booking_id', $booking->id); ?>

                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('booking_number'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->number) ; ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('status'); ?></td>
                          <td><?php echo new_html_entity_decode($status); ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('delivery_date'); ?></td>
                          <td><?php echo _d($booking->delivery_date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('receipt_address'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->receipt_address) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('note'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->note); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-striped no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('customer'); ?></td>
                          <td><a href="#"><?php echo get_company_name($booking->userid); ?></a></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('delivery_date'); ?></td>
                          <td><?php echo _d($booking->delivery_date) ; ?></td>
                       </tr>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('phone'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->phone); ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('delivery_address'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->delivery_address) ; ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
            <h4 class="h4-color mtop25"><?php echo _l('admin_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
            <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('invoice'); ?></td>
                          <td id="invoice-number"><a href="<?php echo admin_url('invoices/preview/'.$booking->invoice_id) ?>"><?php echo ($booking->invoice_id != 0 ? get_invoice_id($booking->invoice_id) : ''); ?></a></td>
                       </tr>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('amount'); ?></td>
                          <td><?php echo to_currency($booking->amount, '') ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('admin_note'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->admin_note); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
          <?php if($booking->rating != 0){ ?>
            <h4 class="h4-color mtop25"><?php echo _l('rating'); ?></h4>
            <hr class="hr-color">
            <div class="row">
            <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('rating'); ?></td>
                          <td>
                          <div class="_star-rating">
                        <a href="#" class="a-rating <?php if($booking->rating >= 1){ echo 'checked'; } ?>" data-rating="1"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating <?php if($booking->rating >= 2){ echo 'checked'; } ?>" data-rating="2"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating <?php if($booking->rating >= 3){ echo 'checked'; } ?>" data-rating="3"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating <?php if($booking->rating >= 4){ echo 'checked'; } ?>" data-rating="4"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating <?php if($booking->rating == 5){ echo 'checked'; } ?>" data-rating="5"><i data-feather="star" class="icon-16"></i></a>
                        <input type="hidden" name="rating" class="rating-value" value="<?php echo new_html_entity_decode($booking->rating); ?>">
                     </div></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('rating_comments'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->comments); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
        <?php } ?>
			</div>
		</div>
		<hr>
			<div class="btn-bottom-toolbar text-right">
				<?php if($booking->rating == 0 && $booking->status == 'complete'){ 
					?>
					<a href="#" onclick="rating(); return false;" class="btn btn-info text-right mright5 text-white"><?php echo _l('rating'); ?></a>
				<?php } ?>
				<a href="<?php echo site_url('fleet_client'); ?>" class="btn btn-default text-right mright5"><?php echo _l('close'); ?></a>
			</div>
		<div class="btn-bottom-pusher"></div>
	</div>
</div>
</div>

<div class="modal fade" id="rating-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content width-100">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    <span><?php echo _l('rating'); ?></span>
                </h4>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php echo form_open('fleet_client/rating/'.$booking->id, array('id' => 'rating-modal')); ?>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                	<label><?php echo _l('rating'); ?></label>
          			<p><div class="star-rating">
          				<a href="#" class="a-rating" data-rating="1"><i data-feather="star" class="solid icon-16"></i></a>
          				<a href="#" class="a-rating" data-rating="2"><i data-feather="star" class="fa-feather icon-16"></i></a>
          				<a href="#" class="a-rating" data-rating="3"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating" data-rating="4"><i data-feather="star" class="icon-16"></i></a>
          				<a href="#" class="a-rating" data-rating="5"><i data-feather="star" class="icon-16"></i></a>
	                    <input type="hidden" name="rating" class="rating-value" value="5">
	                 </div>
	             	</p>
                </div>
              </div>
              <?php echo render_textarea('comments', 'rating_comments', ''); ?>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        	<button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php require 'plugins/Fleet/assets/js/client/booking_detail_js.php';?>

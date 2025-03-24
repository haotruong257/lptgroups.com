<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="row">
      <div class="col-md-3">
        <ul class="list-group help-catagory">
          <?php
          foreach($tab as $key => $gr){
            ?>
            <a href="<?php echo get_uri('fleet/transactions?group='.$gr); ?>" class="list-group-item <?php if($gr == $group){echo 'active ';} ?>"><?php echo app_lang($gr); ?></a>
          <?php } ?>
        </ul>
      </div>
      <div class="col-md-9">
        <div class="panel_s">
           <div class="panel-body">
              <div>
                 <div class="tab-content">
                    <?php echo view('Fleet\Views/'.$tabs['view']); ?>
                 </div>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>

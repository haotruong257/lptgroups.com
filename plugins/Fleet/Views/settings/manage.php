<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="row">
    <div class="col-md-2">
        <div class=" p-2">
            <ul class="nav nav-tabs vertical settings d-block" role="tablist">
              <div class="clearfix settings-anchor" data-bs-toggle="collapse" data-bs-target="#settings-tab-settings">
                  <?php echo app_lang('settings'); ?>
              </div>

              <div id='settings-tab-settings' class='collapse show'>
                  <ul class="list-group help-catagory">
                  <?php
                    foreach($tab as $key => $gr){
                      ?>
                      <a href="<?php echo get_uri('fleet/settings?group='.$gr); ?>" class="list-group-item <?php if($gr == $group){echo 'active ';} ?>"><?php echo app_lang($gr); ?></a>
                    <?php } ?>
                  </ul>
              </div>
            </ul>
            
        </div>
        <ul class="nav nav-tabs vertical settings d-block" role="tablist">
          
        </ul>
      </div>
      <div class="col-md-10">
        <?php
            echo view('Fleet\Views/'.$tabs['view']);
        ?>
      </div>
    </div>
</div>


<ul class="list-group help-catagory">
   <?php
      $i = 0;
      foreach($part_tabs as $gr){
        ?>

         <a href="<?php echo get_uri('fleet/part/'.$part->id.'?group='.$gr['name']); ?>" class="list-group-item <?php if($gr['name'] == $group){echo 'active ';} ?>"><?php echo app_lang($gr['name']); ?></a>

        <?php $i++; } ?>
</ul>

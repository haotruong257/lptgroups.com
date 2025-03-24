<table class="table table-email-logs mtop25">
    <thead>
        <th><?php echo _l('vehicle'); ?></th>
        <?php $start = $month = strtotime($from_date);
        $end = strtotime($to_date);

        while($month < $end)
        { ?>
            <th><?php echo date('m-Y',$month); ?></th>
        <?php 

           $month = strtotime("+1 month", $month);
        } ?>
    </thead>
    <tbody>
      <?php 
        $Fleet_model = model("Fleet\Models\Fleet_model");
        foreach($vehicles as $vehicle){ 
            $cost_meter_trend = $Fleet_model->cost_meter_trend_by_vehicle($vehicle['id'], $from_date, $to_date);
            ?>
            <tr>
              <td><a href="<?php echo site_url('fleet/vehicle/' . $vehicle['id']); ?>" class="invoice-number"><?php echo new_html_entity_decode($vehicle['name']); ?></a></td>
            <?php foreach ($cost_meter_trend as $key => $value) { ?>
              <td><?php echo to_currency($value ?? 0, $currency); ?></td>
            <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php

namespace Fleet\Config;

use CodeIgniter\Events\Events;

Events::on('pre_system', function () {
    helper("fleet");
    helper("fleet_general");
});


<?php

namespace Demo\Config;

use Rating\Models\EvaluationModel;
use CodeIgniter\Config\BaseConfig;

class Demo extends BaseConfig {

    public $app_settings_array = array(
        "demo_file_path" => PLUGIN_URL_PATH . "Demo/files/demo_files/"
    );

    public function __construct() {
        $rating_settings_model = new EvaluationModel();
        
        $settings = $rating_settings_model->get_all_settings()->getResult();
        foreach ($settings as $setting) {
            $this->app_settings_array[$setting->setting_name] = $setting->setting_value;
        }
    }

}

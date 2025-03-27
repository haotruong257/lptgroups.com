<?php

namespace Demo\Config;

use App\Models\EvaluationCriteriaModel;
use CodeIgniter\Config\BaseConfig;
use Rating\Models\EvaluationCriteriaModel as ModelsEvaluationCriteriaModel;

class Demo extends BaseConfig
{
    public $app_settings_array = array(
        "demo_file_path" => PLUGIN_URL_PATH . "Demo/files/demo_files/"
    );

    public function __construct()
    {
        $rating_settings_model = new ModelsEvaluationCriteriaModel();

        $settings = $rating_settings_model->get_all_settings()->getResult();
        foreach ($settings as $setting) {
            $this->app_settings_array[$setting->setting_name] = $setting->setting_value;
        }
    }
}

<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class LoadRiskRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.loadrisk.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}

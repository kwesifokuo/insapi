<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class ComputeMotorPremiumRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.compute_motor_premium.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}

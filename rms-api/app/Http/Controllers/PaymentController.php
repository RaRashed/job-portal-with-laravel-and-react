<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function payment(){
       return view('payment');

    }
   public function getSignature($params, $apiKey)
    {
        if (isset($params['Signature']))
            unset($params['Signature']);

        $chain = is_array($params) ? implode('$', $this->formatSignature($params)) : $params;
        return sha1($chain.'$'.$apiKey);
    }

    public function formatSignature($params)
    {
        $params = array_change_key_case($params, CASE_LOWER);
        ksort($params);

        foreach ($params as $key => $value)
        {
            if (is_array($value))
            {
                $value = array_change_key_case($value, CASE_LOWER);
                ksort($value);

                $params[$key] = implode('$', $this->formatSignature($value));
            }
        }

        return $params;
    }
}

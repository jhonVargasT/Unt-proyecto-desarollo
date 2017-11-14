<?php
/**
 * Created by PhpStorm.
 * User: Chinos
 * Date: 13/11/2017
 * Time: 10:22 PM
 */

namespace App;


class visa
{
    public function sesion($amount)
    {
        $sessionToken = '';
        $merchantId = '';

        $postData = array(
            'sessionToken' => $sessionToken,
            'amount' => $amount,
        );

        $ch = curl_init('https://devapice.vnforapps.com/api.ecommerce/api/v1/ecommerce/token/' . $merchantId . '');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'VisaNet-Session-Key: ' . $sessionToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die(curl_error($ch));
        }

        $responseData = json_decode($response, TRUE);

        return $responseData['expirationTime'];
    }

    public function autorizacion($transactionToken)
    {
        $sessionToken = '';
        $merchantId = '';

        $postData = array(
            'transactionToken' => $transactionToken,
            'sessionToken' => $sessionToken
        );

        $ch = curl_init('https://devapice.vnforapps.com/api.authorization/api/v1/authorization/web/' . $merchantId . '');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die(curl_error($ch));
        }

        $responseData = json_decode($response, TRUE);

        return $responseData['errorMessage'];
    }

}
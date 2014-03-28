<?php
/**
 * OpenPayU
 *
 * @copyright  Copyright (c) 2013 PayU
 * @license    http://opensource.org/licenses/LGPL-3.0  Open Software License (LGPL 3.0)
 *
 * http://www.payu.com
 * http://openpayu.com
 * http://twitter.com/openpayu
 *
 */
namespace OpenPayuSdk\OpenPayu\V2;
use OpenPayuSdk\OpenPayu\OpenPayU;

class OpenPayU_Refund extends OpenPayU
{
    /**
     * Function make refund for order
     * @param $orderId
     * @param $description
     * @param int $amount Amount of refund in pennies
     * @return null|OpenPayU_Result
     * @throws OpenPayU_Exception
     */
    public static function create($orderId, $description, $amount = null)
    {
        if (empty($orderId))
            throw new OpenPayU_Exception('Invalid orderId value for refund');

        if (empty($description))
            throw new OpenPayU_Exception('Invalid description of refund');

        $refund = array(
            'OrderId' => $orderId,
            'Refund' => array('Description' => $description)
        );

        if (!empty($amount))
            $refund['Refund']['Amount'] = (int)$amount;

        $pathUrl = OpenPayU_Configuration::getServiceUrl() . 'order/' . $orderId . '/refund' .
            OpenPayU_Configuration::getDataFormat(true);

        if(OpenPayU_Configuration::getDataFormat() == 'xml') {
            $data = OpenPayU_Util::buildXmlFromArray($refund, 'RefundCreateRequest', '1.0', 'UTF-8');
        }
        elseif(OpenPayU_Configuration::getDataFormat() == 'json') {
            $data = OpenPayU_Util::buildJsonFromArray($refund, 'RefundCreateRequest');
        }

        if (empty($data))
            throw new OpenPayU_Exception('Empty message RefundCreateResponse');

        $result = self::verifyResponse(OpenPayU_Http::post($pathUrl, $data), 'RefundCreateResponse');

        return $result;
    }

    /**
     * @param string $response
     * @param string $messageName
     * @return null|OpenPayU_Result
     */
    public static function verifyResponse($response, $messageName)
    {
        $data = array();
        $httpStatus = $response['code'];

        if (OpenPayU_Configuration::getDataFormat() == 'xml')
            $message = OpenPayU_Util::parseXmlDocument($response['response']);
        elseif (OpenPayU_Configuration::getDataFormat() == 'json')
            $message = OpenPayU_Util::convertJsonToArray($response['response'], true);

        if (isset($message['OpenPayU'][$messageName])) {
            $status = $message['OpenPayU'][$messageName]['Status'];
            $data['Status'] = $status;
            unset($message['OpenPayU'][$messageName]['Status']);
            $data['Response'] = $message['OpenPayU'][$messageName];
        } elseif (isset($message['OpenPayU'])) {
            $status = $message['OpenPayU']['Status'];
            $data['Status'] = $status;
            unset($message['OpenPayU']['Status']);
        }

        $result = self::build($data);

        if ($httpStatus == 200 || $httpStatus == 201 || $httpStatus == 422 || $httpStatus == 302)
            return $result;
        else {
            OpenPayU_Http::throwHttpStatusException($httpStatus, $result);
        }

        return null;
    }
}
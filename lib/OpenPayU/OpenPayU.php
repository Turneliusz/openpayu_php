<?php
/*
	OpenPayU Standard Library

	@copyright  Copyright (c) 2011-2012 PayU
	@license    http://opensource.org/licenses/LGPL-3.0  Open Software License (LGPL 3.0)
	http://www.payu.com
	http://openpayu.com
	http://twitter.com/openpayu
*/
namespace OpenPayuSdk\OpenPayu;

if (!defined('OPENPAYU_LIBRARY'))
    exit;

class OpenPayU extends OpenPayUBase
{

    /**
     * Function builds OrderCreateRequest Document
     * @access public
     * @param string $data
     * @return string
     */
    public static function buildOrderCreateRequest($data)
    {
        $xml = OpenPayU::buildOpenPayURequestDocument($data, 'OrderCreateRequest');
        return $xml;
    }

    /**
     * Function builds OrderRetrieveRequest Document
     * @access public
     * @param array $data
     * @return string $xml
     */
    public static function buildOrderRetrieveRequest($data)
    {
        $xml = OpenPayU::buildOpenPayURequestDocument($data, 'OrderRetrieveRequest');
        return $xml;
    }

    /**
     * Function builds ShippingCostRetrieveResponse Document
     * @access public
     * @param array $data
     * @param string $reqId
     * @return string $xml
     */
    public static function buildShippingCostRetrieveResponse($data, $reqId)
    {

        $cost = array(
            'ResId' => $reqId,
            'Status' => array('StatusCode' => 'OPENPAYU_SUCCESS'),
            'AvailableShippingCost' => $data
        );

        $xml = OpenPayU::buildOpenPayUResponseDocument($cost, 'ShippingCostRetrieveResponse');
        return $xml;
    }

    /**
     * Function builds buildOrderNotifyResponse Document
     * @access public
     * @param string $reqId
     * @return string $xml
     */
    public static function buildOrderNotifyResponse($reqId)
    {

        $data = array(
            'ResId' => $reqId,
            'Status' => array('StatusCode' =>
                OpenPayU_Configuration::getApiVersion() < 2 ? 'OPENPAYU_SUCCESS' : 'SUCCESS')
        );

        $xml = OpenPayU_Util::buildXmlFromArray($data, 'OrderNotifyResponse');
        return $xml;
    }

    /**
     * Function builds verifyResponse Status
     * @access public
     * @param string $data
     * @param string $message
     * @return string $xml
     */
    public static function verifyResponse($data, $message)
    {
        $document = OpenPayU_Util::parseXmlDocument(stripslashes($data));
        $status = null;

        if (OpenPayU_Configuration::getApiVersion() < 2)
            $status = $document['OpenPayU']['OrderDomainResponse'][$message]['Status'];
        else
            $status = $document['OpenPayU'][$message]['Status'];

        if (empty($status) && OpenPayU_Configuration::getApiVersion() < 2)
            $status = $document['OpenPayU']['HeaderResponse']['Status'];

        return $status;
    }

    /**
     * Function returns OrderCancelResponse Status Document
     * @access public
     * @param string $data
     * @return mixed
     */
    public static function verifyOrderCancelResponseStatus($data)
    {
        return OpenPayU::verifyResponse($data, 'OrderCancelResponse');
    }

    /**
     * Function returns OrderStatusUpdateResponse Status Document
     * @access public
     * @param string $data
     * @return mixed
     */
    public static function verifyOrderStatusUpdateResponseStatus($data)
    {
        return OpenPayU::verifyResponse($data, 'OrderStatusUpdateResponse');
    }

    /**
     * Function returns OrderCreateResponse Status
     * @access public
     * @param string $data
     * @return mixed
     */
    public static function verifyOrderCreateResponse($data)
    {
        return OpenPayU::verifyResponse($data, 'OrderCreateResponse');
    }

    /**
     * Function returns OrderRetrieveResponse Status
     * @access public
     * @param string $data
     * @return mixed
     */
    public static function verifyOrderRetrieveResponseStatus($data)
    {
        return OpenPayU::verifyResponse($data, 'OrderRetrieveResponse');
    }

    /**
     * Function returns OrderRetrieveResponse Data
     * @access public
     * @param string $data
     * @return array $document
     */
    public static function getOrderRetrieveResponse($data)
    {
        $response = OpenPayU::parseXmlDocument(stripslashes($data));

        $document = $response['OpenPayU']['OrderDomainResponse']['OrderRetrieveResponse'];

        if (OpenPayU_Configuration::getApiVersion() >= 2)
            $document = $response['OpenPayU']['OrderRetrieveResponse'];

        return $document;
    }

    /**
     * Function builds OrderCancelRequest Document
     * @access public
     * @param string $data
     * @return string $xml
     */
    public static function buildOrderCancelRequest($data)
    {
        $xml = OpenPayU::buildOpenPayURequestDocument($data, 'OrderCancelRequest');

        return $xml;
    }

    /**
     * Function builds OrderStatusUpdateRequest Document
     * @access public
     * @param string $data
     * @return string $xml
     */
    public static function buildOrderStatusUpdateRequest($data)
    {
        $xml = OpenPayU::buildOpenPayURequestDocument($data, 'OrderStatusUpdateRequest');

        return $xml;
    }


    protected static function build($data)
    {
        $instance = new OpenPayU_Result();
        $instance->init($data);

        return $instance;
    }
}
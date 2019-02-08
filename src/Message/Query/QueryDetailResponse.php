<?php

namespace Omnipay\NMI\Message\Query;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\AbstractResponse;

/**
 * NMI Direct Post Response
 */
class QueryDetailResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOWARNING);

        $this->data = $xml;
        parent::__construct($request, $xml);
        $this->transaction = $this->data->transaction;
    }

    public function isSuccessful()
    {
        return isset($this->data->transaction);
    }

    public function getCode()
    {
        return trim($this->data['response']);
    }

    public function getResponseCode()
    {
        return trim($this->data['response_code']);
    }

    public function getMessage()
    {
        return trim($this->data['responsetext']);
    }

    public function getAuthorizationCode()
    {
        return trim($this->data['authcode']);
    }

    public function getAVSResponse()
    {
        return trim($this->data['avsresponse']);
    }

    public function getCVVResponse()
    {
        return trim($this->data['cvvresponse']);
    }

    public function getOrderId()
    {
        return trim($this->data['orderid']);
    }

    public function getTransactionReference()
    {
        return trim($this->data['transactionid']);
    }

    public function getTransactions()
    {
        return $this->data->transaction;
    }

    public function getCardReference()
    {
        if (isset($this->data['customer_vault_id'])) {
            return trim($this->data['customer_vault_id']);
        }

        return null;
    }
}

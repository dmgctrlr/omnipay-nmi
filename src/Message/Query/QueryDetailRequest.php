<?php

namespace Omnipay\NMI\Message\Query;

use Omnipay\NMI\Message\AbstractRequest;

/**
 * NMI Request
 */
class QueryDetailRequest extends AbstractRequest
{
    protected $transaction_id;

    protected $endpoint = "https://secure.networkmerchants.com/api/query.php";
    protected $transactionID;

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        return $this->transactionID;
    }

    /**
     * @param mixed $transactionID
     */
    public function setTransactionReference($transactionID)
    {
        $this->transactionID = $transactionID;
    }

    /**
     * Get data to send.
     */
    public function getData()
    {
        $data = $this->getBaseData();
        if ($this->getTransactionReference()) {
            $data['transaction_id'] = $this->getTransactionReference();
        }

        return $data;
    }

    public function sendData($data)
    {
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            $headers,
            http_build_query($data, '', '&'));

        $this->response = new QueryResponse($this, $httpResponse->getBody()->getContents());
        return $this->response;
    }
}

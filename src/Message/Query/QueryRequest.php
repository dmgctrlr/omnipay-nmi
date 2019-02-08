<?php

namespace Omnipay\NMI\Message\Query;

use Omnipay\NMI\Message\AbstractRequest;

/**
 * NMI Request
 */
class QueryRequest extends AbstractRequest
{
    protected $startTimestamp;
    protected $endTimestamp;
    protected $actionType;
    protected $condition;

    protected $endpoint = "https://secure.networkmerchants.com/api/query.php";

    /**
     * @return mixed
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * @param mixed $actionType
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return int|null
     */
    public function getStartTimestamp()
    {
        return $this->startTimestamp;
    }

    /**
     * @param int|null $startTimestamp unix timestamp
     */
    public function setStartTimestamp($startTimestamp)
    {
        $this->startTimestamp = $startTimestamp;
    }

    /**
     * @return int|null
     */
    public function getEndTimestamp()
    {
        return $this->endTimestamp;
    }

    /**
     * @param int|null $endTimestamp unix timestamp
     */
    public function setEndTimestamp($endTimestamp)
    {
        $this->endTimestamp = $endTimestamp;
    }

    /**
     * Get data to send.
     */
    public function getData()
    {
        $data = $this->getBaseData();
        if ($this->getStartTimestamp()) {
            $data['start_date'] = date('YmdHis', $this->getStartTimestamp());
        }

        if ($this->getEndTimestamp()) {
            $data['end_date'] = date('YmdHis', $this->getEndTimestamp());
        }

        if ($this->getActionType()) {
            $data['action_type'] = $this->getActionType();
        }

        if ($this->getCondition()) {
            $data['condition'] = $this->getCondition();
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

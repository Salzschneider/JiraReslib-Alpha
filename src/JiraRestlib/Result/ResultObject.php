<?php

namespace JiraRestlib\Result;
use JiraRestlib\Result\ResultAbstract;
use JiraRestlib\Result\ResultException;
use JiraRestlib\HttpClients\HttpClientAbstract;


class ResultObject extends ResultAbstract
{
    /**
     * Constructor
     * 
     * @param \JiraRestlib\Result\HttpClientInterface $httpClient
     * @return void
     */
    public function __construct(HttpClientAbstract $httpClient)
    {
        parent::__construct($httpClient);

        try
        {
            $this->response = json_decode($httpClient->getResponseBody(), false); 
            $this->format = parent::RESPONSE_FORMAT_OBJECT;
        }
        catch(\GuzzleHttp\Exception\ParseException $e)
        {
            throw new ResultException((string)$httpClient->getResponseBody());
        }
    }
    
    /**
     * Get errors
     * 
     * @return array
     */
    public function getErrors()
    {
        $returnErrors = array();
        
        if(!empty($this->response->errors))
        {
            $returnErrors = (array)$this->response->errors;
        }
        
        return $returnErrors;
    }
    
    /**
     * Get the list of error messages
     * 
     * @return array
     */
    public function getErrorMessages()
    {
        $returnMessages = array();
        
        if(!empty($this->response->errorMessages))
        {
            $returnMessages = $this->response->errorMessages;
        }
        
        return $returnMessages;
    }
}
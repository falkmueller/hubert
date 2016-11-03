<?php

namespace hubert;

class controller {
    
    protected $_container;
    protected $_response;
    
    public function setContainer($container){
        $this->_container = $container;
    }
    
    public function setResponse($response){
        $this->_response = $response;
    }
    
    /**
     * set redirekt url in response
     * @param string $url
     * @param int $status
     * @return \Zend\Diactoros\Response
     */
    protected function responseRedirect($url, $status = null)
    {
        $responseWithRedirect = $this->_response->withHeader('Location', (string)$url);
        if (is_null($status) && $this->_response->getStatusCode() === 200) {
            $status = 302;
        }
        if (!is_null($status)) {
            return $responseWithRedirect->withStatus($status);
        }
        return $responseWithRedirect;
    }

    /**
     * transform response for with json-data
     * @param type $data
     * @param int $status
     * @param type $encodingOptions
     * @return \Zend\Diactoros\Response
     * @throws \RuntimeException
     */
    protected function responseJson($data, $status = null, $encodingOptions = 0)
    {
        $body = $this->_response->getBody();
        $body->rewind();
        $body->write($json = json_encode($data, $encodingOptions));
        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }
        $responseWithJson = $this->_response->withHeader('Content-Type', 'application/json;charset=utf-8');
        if (isset($status)) {
            return $responseWithJson->withStatus($status);
        }
        return $responseWithJson;
    }
    
    /**
     * render template in response
     * @param string $template
     * @param array $data
     * @return \Zend\Diactoros\Response
     */
    protected function responseTemplate($template, $data = array()){
        
        if(!isset($this->_container["template"])){
            throw new \Exception("no template engine installed");
        }
        $html = $this->_container["template"]->render($template, $data);
        $this->_response->getBody()->write($html);
        
        return $this->_response;
        
    }
    
}

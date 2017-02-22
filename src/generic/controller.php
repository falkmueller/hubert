<?php

namespace hubert\generic;

abstract class controller implements \hubert\interfaces\controller {
    
    protected $_container;
    protected $_response;

    public function setResponse($response){
        $this->_response = $response;
    }
    
    public function getResponse(){
        return $this->_response;
    }


    protected function getRequest(){
        return hubert()->request;
    }
    
    public function dispatch($action, $params){
        $action_name = $action."Action";
        
        if(!method_exists($this,$action_name)){
            $classname = get_class($this);
            throw new \Exception("methode {$action_name} in controller {$classname} not exists");
        }
        
        return $this->$action_name($params);
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
        
        if(!isset(hubert()->template)){
            throw new \Exception("no template engine installed");
        }
        $html = hubert()->template->render($template, $data);
        $this->_response->getBody()->write($html);
        
        return $this->_response;
        
    }
    
}

<?php
/*
//This is the structure of JSON data we are expecting for every response

{
    "statusCode": 200,
    "success": true,
    "messages": [
        "This is working",
        "Second message just for fun"
    ],
    "data": "data is life"
}

*/

    class Response {

        //initialize the variables for this response function
        private $_httpStatusCode;
        private $_success;
        private $_messages = array();
        private $_data;
        private $_toCache = false; // we will enable when appropriate
        private $_responseData = array();

        
        //define those variables that can be set from an external function
        public function setSuccess($success){
            $this -> _success = $success; // dont use the $ sign when you're making use of the variable (eg _success)
        }

        public function setHttpStatusCode($httpStatus){
            $this -> _httpStatusCode = $httpStatus;
        }

        public function addMessage($msg){
            $this -> _messages[] = $msg;
        }

        public function setData($data){
            $this -> _data = $data;
        }

        public function toCache($toCache){
            $this -> _toCache = $toCache;
        }

        //create the function that sends a response back to the user
        public function send(){

            header('Content-type: application/json; charset=utf-8'); //data type

            //determine which response can be cached
            if($this->_toCache === true){
                header('Cache-control: max-age=60');
            } else {
                header('Cache-control: no-cache, no-store');
            }

            //Check if data was successfully sent
            if(($this->_success !== false && $this->_success !== true) || (!is_numeric($this->_httpStatusCode))){ //if the response is neither true nor false or the http status code returned is not a number.
                http_response_code(500); //for any other unknown kind of error
                
                //add the status code and response data to what the user sees as an error message (just for visibility)
                $this->_responseData['statusCode'] = 500;
                $this->_responseData['success'] = false;
                $this->addMessage("Response Creation Error");
                $this->_responseData['messages'] = $this->_messages;
            }
            else {
                http_response_code($this->_httpStatusCode);

                $this->_responseData['statusCode'] = $this->_httpStatusCode;
                $this->_responseData['success'] = $this->_success;
                $this->_responseData['messages'] = $this->_messages;
                $this->_responseData['data'] = $this->_data;
            }

            echo json_encode($this->_responseData); // output the response in json format using the php json_encode()
        }


    }

?>
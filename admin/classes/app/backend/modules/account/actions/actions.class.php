<?php
use \Firebase\JWT\JWT;
  
class accountActions extends Controller {
  
    function executeLogin() {
        if (isset($_SESSION['accountId']) && ((int)$_SESSION['accountId'])) {
            $this->router->redirect('/');
        }
        if (strlen($this->input->get('token'))>25) {
            $token = $this->input->get('token');
            $_SESSION['jwt'] = $token;
            $api = new ApiV2();
            //$api->setDoRedirectOnFail(false);
            $api->get('maker?per_page=1');
            $_SESSION['httpCode'] = $api->getHttpCode();
            if (!$api->responseHadError()) {
                $_SESSION['accountId'] = 23;
                $_SESSION['jwt'] = $this->input->get('token');

                $decode = JWT::decode($this->input->get('token'), Config::getKey('api','jwtSecret'), Config::getKey('api','algorithm'));
                $_SESSION['payload']['userId'] = $decode->userId;
                $_SESSION['payload']['userRole'] = $decode->userRole;
                $this->router->redirect('/');
            } else {
                unset($_SESSION['accountId']);
                unset($_SESSION['payload']);
                $response = $api->getResponseBodyJson();
                $_SESSION['loginError'] = $response->error;
            }
        }
        $this->render->setData('email', $this->input->get('email'));
    }
    
    function executeLogout() {
        $_SESSION['accountId'] = null;
        $_SESSION['filter'] = null;
        $this->router->redirect('/');
    }
    
}

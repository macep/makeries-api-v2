<?php
  
class userActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'region';
        $this->adminUrl = 'region';
    }
    
    function executeIndex() {
        $filter = ['name'=>''];
        $api = new ApiAuth0();
        $results = $api->getUsers();

        $this->render->setData('users', $results);
        $this->render->setData('filter', $filter);
        Breadcrumb::add(null,'Users');
    }
    
    public function executeEdit() {
        $user = null;
        $id = $this->input->get('id');

        $api = new ApiAuth0();
        $user = $api->getUser($id);

        $userData = [
                     'id'       => null,
                     'email'    => null,
                     'username' => null,
                     'userId'   => null,
                     'userRole' => null,
                     'accessToGroup' => null
                    ];
        if (isset($user['user_id'])) {
            $userData['id'] = $user['user_id'];
        }
        if (isset($user['email'])) {
            $userData['email'] = $user['email'];
        }
        if (isset($user['username'])) {
            $userData['username'] = $user['username'];
        }
        if (isset($user['user_metadata'])) {
            if (isset($user['user_metadata']['userId'])) {
                $userData['userId'] = $user['user_metadata']['userId'];
            }
            if (isset($user['user_metadata']['userRole'])) {
                $userData['userRole'] = $user['user_metadata']['userRole'];
            }
            if (isset($user['user_metadata']['accessToGroup'])) {
                $userData['accessToGroup'] = $user['user_metadata']['accessToGroup'];
            }
        }
        $this->render->setData('user', $userData);
        $this->render->setData('userRoles',  ['superAdmin', 'groupAdmin', 'readOnlyAdmin']);

        Breadcrumb::add('/'.$this->adminUrl.'/index','Users');
        Breadcrumb::add(null, $userData['email'] ? $userData['email'] : 'Add user');
    }

    public function executeAjaxsave($lock = true) {
        $api = new ApiAuth0();

        $id = $this->input->get('id');
        if(strlen($id)) {
            $data = [
                     //'username'=>$this->input->get('username'),
                     //'email'=>$this->input->get('email'),
                     'user_metadata'=>[
                        'userId'=>$_POST['user_id'],
                        'userRole'=>$_POST['userRole'],
                        'accessToGroup'=>$_POST['accessToGroup'],
                     ]
                     //'password'=>'12A34secret5',
                     //'connection'=>'Username-Password-Authentication'
                     ];
            try {
                $api->updateUser($this->input->get('id'), $data);
                echo '1';
            } catch (Exception $e) {
                echo '0'.$e->getMessage();
            }
        } else {
            $data = [
                     'username'=>$this->input->get('username'),
                     'email'=>$this->input->get('email'),
                     'user_metadata'=>[
                        'userId'=>$_POST['user_id'],
                        'userRole'=>$_POST['userRole'],
                        'accessToGroup'=>$_POST['accessToGroup'],
                     ],
                     'password'=>$this->input->get('pass'),
                     'connection'=>'Username-Password-Authentication'
                     ];
            try {
                $api->addUser($data);
                echo '1';
            } catch (Exception $e) {
                echo '0'.$e->getMessage();
            }
        }
        exit;
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $region = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
}

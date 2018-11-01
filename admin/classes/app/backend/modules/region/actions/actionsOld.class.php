<?php
  
class regionActions extends ControllerApi {
  
    function __construct() {
        $this->searchFields = ['name'];
        $this->apiUrl = 'region';
        $this->adminUrl = 'region';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('regions', $results);
        Breadcrumb::add(null,'Regions');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $region = $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Regions');
        Breadcrumb::add(null, $region ? $region->name : 'invalid id');

        $this->render->setData('region', $region);
    }

    public function executeAjaxsave() {
        $params = [];
        $params['name'] = $this->input->get('name');
        $response = $this->addOrUpdate($params);
        if (!$response['error']) {
            echo 1;
            exit;
        }
        echo '0'.$response['message'];
        exit;
    }

    public function executeSave() {
        if (0 == (int)$this->input->get('id')) {
            $this->saveNew();
        } else {
            $this->saveExisting();
        }

        $this->router->redirect('/'.$this->adminUrl.'/index');
    }
    
    public function executeAjaxadd() {
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->add($this->apiUrl, $fields);
        if (201 == $apiV2->getHttpCode()) {
            echo '1';
        } else {
            $datas = $apiV2->getResponseBody();
            $response = '';
            foreach ($datas as $key=>$value) {
#var_dump($key, $value);
                $response .= '<br>'. implode(',', $value);
            }
            echo '0'. $response;
        }
        exit;
    }

    public function executeAjaxsaveOld() {
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->edit($this->apiUrl.'/'.(int)$this->input->get('id'), $fields);
#var_dump($apiV2->getHttpCode(), $apiV2->getResponseBody());
        if (200 == $apiV2->getHttpCode()) {
            echo '1';
        } else {
            $datas = $apiV2->getResponseBody();
            $response = '';
            foreach ($datas as $key=>$value) {
#var_dump($key, $value);
                $response .= '<br>'. implode(',', $value);
            }
            echo '0'. $response;
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
    
    private function saveNew() {
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->add($this->apiUrl, $fields);
        return $apiV2->getHttpCode();
    }
    
    private function saveExisting() {
        $id = (int)$this->input->get('id');
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->edit($this->apiUrl . '/' . $id, $fields);
        return $apiV2->getHttpCode();
    }
    
    public function getResults($filter = array(), &$pagination = null) {
        $apiV2 = new ApiV2();
        $url = $this->apiUrl . '?';

        if (strlen($filter['name'])) {
            $url .= 'name='.$filter['name'];
        }
        $results = $apiV2->callPagination($url, $filter);
        $pagination = $results['pagination'];

        if (!is_array($results['response'])) {
            $results['response'] = [];
        }
        return $results['response'];
    }
    
}

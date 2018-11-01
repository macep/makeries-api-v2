<?php
  
class makergroupActions extends ControllerApi {
  
    function __construct() {
        $this->searchFields = ['name'];
        $this->apiUrl = 'makergroup';
        $this->adminUrl = 'makergroup';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('makergroups', $results);
        Breadcrumb::add(null,'Maker Groups');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        $apiV2 = new ApiV2();
        if (0 == $id) {
            $makergroup = new stdClass();
            $makergroup->name = null;
        } else {
            $makergroup = $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        $regions = $apiV2->getJson('region');
        $products = $apiV2->getJson('product');
        $businessTypes = $apiV2->getJson('businesstype');
        $serviceTypes = $apiV2->getJson('servicetype');

        Breadcrumb::add('/'.$this->adminUrl.'/index','Maker Groups');
        Breadcrumb::add(null, $makergroup ? $makergroup->name : 'invalid id');

        $this->render->setData('makergroup', $makergroup);

        $this->render->setData('regions', $regions);
        $this->render->setData('products', $products);
        $this->render->setData('businessTypes', $businessTypes);
        $this->render->setData('serviceTypes', $serviceTypes);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $makergroup = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
    public function executeAjax() {
        $fields = [];
        $id = (int)$this->input->get('id');
        $fields['name'] = $this->input->get('name');
        if ($this->input->get('region_id', null)) {
            $fields['regions'] = implode(',', $this->input->get('region_id',[]));
        } else {
            $fields['regions'] = 0;
        }
        if ($this->input->get('product_id', null)) {
            $fields['products'] = implode(',', $this->input->get('product_id',[]));
        } else {
            $fields['products'] = 0;
        }
        if ($this->input->get('business_type_id', null)) {
            $fields['business_types'] = implode(',', $this->input->get('business_type_id',[]));
        } else {
            $fields['business_types'] = 0;
        }
        if ($this->input->get('service_type_id', null)) {
            $fields['service_types'] = implode(',', $this->input->get('service_type_id',[]));
        } else {
            $fields['service_types'] = 0;
        }
        $apiV2 = new ApiV2();
        if ($id) {
            $apiV2->update($this->apiUrl.'/'.$id, $fields);
            if (!$apiV2->responseHadError()) {
                echo '1';
                exit;
            }
        } else {
            $apiV2->add($this->apiUrl, $fields);
            if (!$apiV2->responseHadError()) {
                echo '1';
                exit;
            }
        }
#var_dump($field, $apiV2->getHttpCode(), $apiV2->getResponseBody());
        $datas = $apiV2->getResponseBodyJson();
        $response = '';
        foreach ($datas as $key=>$value) {
#var_dump($key, $value);
            $response .= '<br>'. implode(',', $value);
        }
        echo '0'. $response;
        exit;
    }

    private function saveNew() {
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->add($this->apiUrl, $fields);
    }
    
    private function saveExisting() {
        $id = (int)$this->input->get('id');
        $fields = [];
        $fields['name'] = $this->input->get('name');
        
        $apiV2 = new ApiV2();
        $apiV2->edit($this->apiUrl . '/' . $id, $fields);
    }
    
}

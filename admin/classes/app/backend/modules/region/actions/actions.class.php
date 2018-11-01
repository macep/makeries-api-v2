<?php
  
class regionActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
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
        $region = null;
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $apiV2->getOne($this->apiUrl . '/' . $id);
            if (!$apiV2->responseHadError()) {
                $region  = $apiV2->getResponseBodyJson();
            }
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Regions');
        Breadcrumb::add(null, $region ? $region->name : 'invalid id');

        $this->render->setData('region', $region);
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

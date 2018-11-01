<?php
  
class servicetypeActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'servicetype';
        $this->adminUrl = 'servicetype';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('servicetypes', $results);
        Breadcrumb::add(null,'Service Types');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $servicetype = $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Service Types');
        Breadcrumb::add(null, $servicetype ? $servicetype->name : 'invalid id');

        $this->render->setData('servicetype', $servicetype);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $servicetype = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
}

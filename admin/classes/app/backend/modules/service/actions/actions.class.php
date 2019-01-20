<?php
  
class serviceActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'service';
        $this->adminUrl = 'service';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('services', $results);
        Breadcrumb::add(null,'Services');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $service= $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Services');
        Breadcrumb::add(null, $service ? $service->name : 'invalid id');

        $this->render->setData('service', $service);
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

<?php
  
class materialActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'material';
        $this->adminUrl = 'material';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('materials', $results);
        Breadcrumb::add(null,'Materials');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $material = $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Materials');
        Breadcrumb::add(null, $material ? $material->name : 'invalid id');

        $this->render->setData('material', $material);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $material = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
}

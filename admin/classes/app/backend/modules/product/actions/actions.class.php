<?php
  
class productActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'product';
        $this->adminUrl = 'product';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('products', $results);
        Breadcrumb::add(null,'Products');
    }
    
    public function executeEdit() {
        $id = (int)$this->input->get('id');
        if (0 == $id) {
            $this->router->redirect('/'.$this->adminUrl.'/index/');
        } else {
            $apiV2 = new ApiV2();
            $product = $apiV2->getOne($this->apiUrl . '/' . $id);
        }

        Breadcrumb::add('/'.$this->adminUrl.'/index','Products');
        Breadcrumb::add(null, $product ? $product->name : 'invalid id');

        $this->render->setData('product', $product);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $product = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
}

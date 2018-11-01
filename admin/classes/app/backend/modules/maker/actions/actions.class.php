<?php
  
class makerActions extends ControllerApi {
  
    function __construct() {
        $this->searchFields = ['name','email','address1','city','postcode','telephone'];
        $this->objectFields = [
                               'name', 'address1', 'address2','city','postcode','email','telephone','website',
                               'social1','social2','social3','map_url','admin_email','brief_description','long_description'
                               ];
        $this->apiUrl = 'maker';
        $this->adminUrl = 'maker';
    }
    
    function executeIndex() {
        $filter = $this->getSearchFilter();

        $pagination = ['current'=>1, 'per'=>20];
        $results = $this->getResults($filter, $pagination);

        $this->render->setData('filter', $filter);
        $this->render->setData('linkMore', $this->getLinkMore($filter));
        
        $this->render->setData('pagination', $pagination);
        $this->render->setData('makers', $results);
        Breadcrumb::add(null,'Makers');
    }
    
    public function executeView() {
        $id = (int)$this->input->get('id');
        if ((int)$id) {
            $apiV2 = new ApiV2();
            $apiV2->get($this->apiUrl . '/' . $id);
            $maker = $apiV2->getResponseBodyJson();
            $this->render->setData('maker', $maker);

            $apiV2->get('media?maker_id=' . $id);
            $medias = $apiV2->getResponseBodyJson();
            $apiV2->get('project?maker_id=' . $id);
            $projects = $apiV2->getResponseBodyJson();

            $this->render->setData('medias', $medias);
            $this->render->setData('projects', $projects);
            $this->render->setData('tab', $this->input->get('tab','image'));
        }
    }

    public function executeEdit() {
        $id = (int)$this->input->get('id');
        $apiV2 = new ApiV2();
        if (0 == $id) {
            $maker = new stdClass();
            $maker->id = 0;
            $maker->name = null;
            $maker->address1 = null;
            $maker->address2 = null;
            $maker->city = null;
            $maker->postcode = null;
            $maker->email = null;
            $maker->telephone = null;
            $maker->website = null;
            $maker->social1 = null;
            $maker->social2 = null;
            $maker->social3 = null;
            $maker->map_url = null;
            $maker->admin_email = null;
            $maker->brief_description = null;
            $maker->long_description = null;
            $maker->published = null;
            $maker->featured = null;
            $maker->subscription = null;
        } else {
            $maker = $apiV2->getOne($this->apiUrl . '/' . $id);
        }
#var_dump($maker);
        $regions = $apiV2->get('region');
        $products = $apiV2->get('product');
        $businessTypes = $apiV2->get('businesstype');
        $serviceTypes = $apiV2->get('servicetype');

        Breadcrumb::add('/'.$this->adminUrl.'/index','Makers');
        Breadcrumb::add(null, $maker ? $maker->name : 'invalid id');

        $this->render->setData('maker', $maker);

        $this->render->setData('regions', $regions);
        $this->render->setData('products', $products);
        $this->render->setData('businessTypes', $businessTypes);
        $this->render->setData('serviceTypes', $serviceTypes);

        $makerGroups = $apiV2->get('makergroup');
        $this->render->setData('makerGroups', $makerGroups);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $maker = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/'.$this->adminUrl.'/index');
                }
            }
        }
    }
    
    public function executeAjax() {
        $params = [];
		foreach ($this->objectFields as $field) {
	        $value = $this->input->get($field);
            if ($value && strlen($value)) {
    	        $params[$field] = $value;
            }
		}
        $params['published'] = $this->input->get('published',null) ? 'yes' : 'no';
        $params['subscription'] = $this->input->get('subscription',null) ? 'yes' : 'no';
        $params['featured'] = $this->input->get('featured',null) ? 'yes' : 'no';

        if ($this->input->get('region_id', null)) {
            $params['regions'] = implode(',', $this->input->get('region_id',[]));
        }
        if ($this->input->get('product_id', null)) {
            $params['products'] = implode(',', $this->input->get('product_id',[]));
        }
        if ($this->input->get('business_type_id', null)) {
            $params['business_types'] = implode(',', $this->input->get('business_type_id',[]));
        }
        if ($this->input->get('service_type_id', null)) {
            $params['service_types'] = implode(',', $this->input->get('service_type_id',[]));
        }
        if ($this->input->get('maker_group_id', null)) {
            $params['maker_groups'] = implode(',', $this->input->get('maker_group_id',[]));
        }

        if ($_SESSION['payload']['userRole'] == 'groupAdmin' && 0 == strlen($params['maker_groups'])) {
            echo '0Please select at least one maker group';exit;
        }
#echo 0;
#var_dump($params);exit;
        $response = $this->addOrUpdate(json_encode($params));
        if (!$response['error']) {
            echo 1;
            exit;
        }
        echo '0'.$response['message'];
        exit;
    }

}

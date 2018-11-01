<?php
  
class projectActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['maker_id', 'name', 'description'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'project';
        $this->adminUrl = 'project';
    }

    /*
    public function executeAjaxsave() {
        $this->ajaxsave();
        $this->router->redirect('/maker/view?id='.$this->input->get('maker_id').'&tab=project');
    }
    */

    public function executeEdit() {
        $id = (int)$this->input->get('id');
        $apiV2 = new ApiV2();
        $project = $apiV2->getOne($this->apiUrl . '/' . $id);
        if (!$project) {
            $this->router->redirect('/');
        }
        $maker = $apiV2->getOne('maker/' . $project->maker_id);

        Breadcrumb::add('/maker/index','Maker');
        Breadcrumb::add('/maker/index?id='.$maker->id,$maker->name);
        Breadcrumb::add(null, $project->name);

        $this->render->setData('project', $project);
        $this->render->setData('maker', $maker);
    }
    
    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $project = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/maker/view?id='.$project->maker_id.'&tab=project');
                }
            }
        }
        exit;
    }

    public function executeAjaxlist() {
        $this->render->setTemplate('blank.php');
        $pagination = [];
        $filter = [];
        $filter['maker_id'] = $this->input->get('maker_id');
        $filter['pageNr'] = $this->input->get('page_nr',1);
        $projects = $this->getResults($filter, $pagination);
        $this->render->setData('maker_id', $filter['maker_id']);
        $this->render->setData('projects', $projects);
        $this->render->setData('pagination', $pagination);
    }

}

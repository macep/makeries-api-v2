<?php
  
class mediaActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['maker_id', 'name', 'url'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'media';
        $this->adminUrl = 'media';
    }
    
    /*
    public function executeAjaxsave() {
        $this->ajaxsave();
        $this->router->redirect('/maker/view?id='.$this->input->get('maker_id').'&tab=media');
    }
    */

    public function executeEdit() {
        $id = (int)$this->input->get('id');
        $apiV2 = new ApiV2();
        $media = $apiV2->getOne($this->apiUrl . '/' . $id);
        if (!$media) {
            $this->router->redirect('/');
        }
        $maker = $apiV2->getOne('maker/' . $media->maker_id);

        Breadcrumb::add('/media/index','Maker');
        Breadcrumb::add('/media/index?id='.$maker->id,$maker->name);
        Breadcrumb::add(null, $media->name);

        $this->render->setData('maker', $maker);
        $this->render->setData('media', $media);
    }

    public function executeDelete() {
        $id = (int)$this->input->get('id');
        if ($id) {
            $apiV2 = new ApiV2();
            $media = $apiV2->getOne($this->apiUrl . '/' . $id);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/maker/view?id='.$media->maker_id.'&tab=media');
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
        $medias = $this->getResults($filter, $pagination);
        $this->render->setData('maker_id', $filter['maker_id']);
        $this->render->setData('medias', $medias);
        $this->render->setData('pagination', $pagination);
    }

}

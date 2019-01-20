<?php
  
class imageActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['maker_id', 'name'];
        $this->searchFields = ['name'];
        $this->apiUrl = 'media';
        $this->adminUrl = 'media';
    }
    
    public function executeAjaxsave($lock = false) {
        $makerId = $this->input->get('maker_id');
        $this->apiUrl = 'maker/'.$makerId.'/image';
        parent::executeAjaxsave();
        exit;
        //$this->router->redirect('/maker/view?id='.$this->input->get('maker_id').'&tab=image');
    }

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
        $makerId = $this->input->get('maker_id');
        $id = (int)$this->input->get('id');
#var_dump($makerId, $id);
        if ($makerId && $id) {
            $apiV2 = new ApiV2();
            $this->apiUrl = 'maker/'.$makerId.'/image';
            $image = $apiV2->getOne($this->apiUrl . '/' . $id);
#var_dump($image);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    $this->router->redirect('/maker/view?id='.$makerId.'&tab=image');
                }
            }
        }
        exit;
    }

    public function executeView() {
        $makerId = $this->input->get('maker_id');
        $id = $this->input->get('id');
        $url = 'maker/'.$makerId.'/image/'.$id.'?thumb=1';
        $apiV2 = new ApiV2();
        $apiV2->get($url);

        $data = $apiV2->getResponseBody();
        
        $im = imagecreatefromstring(base64_decode($data));
        if ($im !== false) {
            header('Content-Type: image/png');
            imagepng($im);
            imagedestroy($im);
        }
        echo 'An error occurred.';
        
    }

    public function executeAjaxlist() {
        $this->render->setTemplate('blank.php');
        $makerId = $this->input->get('maker_id');
        $pagination = [];
        $filter = [];
        $this->apiUrl = 'maker/'.$makerId.'/image';
        $filter['pageNr'] = $this->input->get('page_nr',1);
        $images = $this->getResults($filter, $pagination);
        foreach ($images as $image) {
            $apiV2 = new ApiV2();
            $url = $this->apiUrl .'/'.$image->id;
            $apiV2->get($url);
            $image->dataContent = $apiV2->getResponseBodyJson();
#var_dump($apiV2->getHttpCode(), $apiV2->getResponseBody());
#print '<pre>';
#print_r($apiV2->getResponseHeaders());
#exit;
        }
        $this->render->setData('maker_id', $makerId);
        $this->render->setData('images', $images);
        $this->render->setData('pagination', $pagination);
    }

}

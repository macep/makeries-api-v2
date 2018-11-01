<?php
  
class projectimageActions extends ControllerApi {
  
    function __construct() {
        $this->objectFields = ['project_id', 'name'];
        $this->searchFields = ['name'];
        $this->apiUrl = '';
        $this->adminUrl = 'media';
    }
    
    public function executeAjaxsave($lock = false) {
        $projectId = $this->input->get('project_id');
        $this->apiUrl = 'project/'.$projectId.'/image';
        parent::executeAjaxsave(false);
        $this->router->redirect('/maker/view?id='.$this->input->get('maker_id').'&tab=project');
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
    
    public function executePage() {
        $this->render->setTemplate('blank.php');
        $project_id = (int)$this->input->get('project_id');
        $apiV2 = new ApiV2();
        $project= $apiV2->getOne('project/' . $project_id);
        if (!$project) {
            $this->router->redirect('/');
        }
        /*
        $maker = $apiV2->getOne('maker/' . $media->maker_id);

        Breadcrumb::add('/media/index','Maker');
        Breadcrumb::add('/media/index?id='.$maker->id,$maker->name);
        Breadcrumb::add(null, $media->name);
*/
        $this->render->setData('project', $project);
    }    

    public function executeDelete() {
        $makerId = $this->input->get('maker_id');
        $projectId = $this->input->get('project_id');
        $id = (int)$this->input->get('id');
#var_dump($makerId, $id);
        if ($makerId && $id) {
            $apiV2 = new ApiV2();
            $this->apiUrl = 'project/'.$projectId.'/image';
            $image = $apiV2->getOne($this->apiUrl . '/' . $id);
#var_dump($image);
            if (200 == $apiV2->getHttpCode()) {
                $apiV2->delete($this->apiUrl . '/' . $id);
                if (204 == $apiV2->getHttpCode()) {
                    echo 1;
                    exit;
                    $this->router->redirect('/maker/view?id='.$makerId.'&tab=image');
                }
            }
        }
        echo 0;
        exit;
    }

    public function executeView() {
        $projectId = $this->input->get('project_id');
        $id = $this->input->get('id');
        $url = 'project/'.$projectId.'/image/'.$id;
        $apiV2 = new ApiV2();
        $apiV2->get($url);

        $data = $apiV2->getResponseBody();
        
        $im = imagecreatefromstring($data);
        if ($im !== false) {
            header('Content-Type: image/png');
            imagepng($im);
            imagedestroy($im);
        }
        echo 'An error occurred.';
    }

    public function executeAjaxlist() {
        $this->render->setTemplate('blank.php');
        $projectId = $this->input->get('project_id');
        $pagination = [];
        $filter = [];
        $this->apiUrl = 'project/'.$projectId.'/image';
        $filter['pageNr'] = $this->input->get('page_nr',1);
        $images = $this->getResults($filter, $pagination);
        foreach ($images as $image) {
            $apiV2 = new ApiV2();
            $url = $this->apiUrl .'/'.$image->id;
            $apiV2->get($url);
            $image->dataContent = $apiV2->getResponseBodyJson();
        }
        $this->render->setData('project_id', $projectId);
        $this->render->setData('images', $images);
        $this->render->setData('pagination', $pagination);
    }

}

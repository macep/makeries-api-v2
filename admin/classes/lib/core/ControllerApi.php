<?
/**
 * Base controller for api class
 *
 */

class ControllerApi extends Controller
{

	public $searchFields = [];
	public $objectFields = [];
	public $apiUrl = null;
	public $adminUrl = null;

	public function getSearchFilter() {
        $filter = [];

        $filterSource= (array)json_decode($_SESSION['filter']);
        $filter = isset($filterSource[$this->adminUrl]) ? (array)$filterSource[$this->adminUrl] : array('pageNr'=>null);
        if (strlen($_SERVER['QUERY_STRING'])) {
			foreach ($this->searchFields as $field) {
	            $filter[$field] = $this->input->get($field,'');
			}
            $filter['pageNr'] = $this->input->get('pageNr',1);
            $filterSource[$this->adminUrl]  =  $filter;
            $_SESSION['filter'] = json_encode($filterSource);
        }

        $filter = mandatoryFields($filter, $this->searchFields);
		return $filter;
	}

	public function getLinkMore($filter) {
        $linkMore = '';
        foreach($filter as $key=>$value) {
            if ($key == 'pageNr') {
                continue;
            }
            if (strlen($value)) {
                $linkMore .= '&'.$key.'='.$value;
            }
        }
		return $linkMore;
	}

	public function addOrUpdate($params, $files = []){
		$response = ['error'=>true,'httpCode'=>null, 'message'=>null];

        $id = (int)$this->input->get('id');
		$apiV2 = new ApiV2();
        if ($id) {
            $apiV2->update($this->apiUrl.'/'.$id, $params, $files);
            if (!$apiV2->responseHadError()) {
				$response['error'] = false;
				return $response;
            }
        } else {
            $apiV2->add($this->apiUrl, $params, $files);
            if (!$apiV2->responseHadError()) {
				$response['error'] = false;
				return $response;
            }
        }
		if ($apiV2->isResponseJson()) {
			$datas = $apiV2->getResponseBodyJson();
			foreach ($datas as $key=>$value) {
				$response['message'] .= '<br>'. implode(',', $value);
			}
		} else {
			$response['message'] = $apiV2->getResponseBody();
		}
		return $response;
	}

    public function ajaxsave() {
        $params = [];
		$files  = [];
		foreach ($this->objectFields as $field) {
			$params[$field] = $this->input->get($field);
		}
        return $this->addOrUpdate($params, $_FILES);
    }

	public function executeAjaxsave($lock = true) {
        $response = $this->ajaxsave();
        if (!$response['error']) {
			if ($lock) {
				echo 1;
				exit;
			} else {
				return true;
			}
        }
		if ($lock) {
			echo '0'.$response['message'];
			exit;
		} else {
			return false;
		}
    }

    public function getResults($filter = array(), &$pagination = null) {
        $apiV2 = new ApiV2();
        $url = $this->apiUrl . '?';

		foreach ($filter as $key=>$value) {
			if (strlen($value)) {
				$url .= '&'.$key . '='.$value;
			}
		}
        $results = $apiV2->callPagination($url, $filter);
        $pagination = $results['pagination'];

        if (!is_array($results['data'])) {
            $results['data'] = [];
        }
        return $results['data'];
    }

}
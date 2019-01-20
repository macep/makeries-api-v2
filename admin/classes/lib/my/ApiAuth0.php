<?php

use Auth0\SDK\API\Management;

class ApiAuth0 {

    public function getManagement() {
        $access_token = Config::getKey('auth0','token');
        if ( empty( $access_token ) ) {
            // See "Client Credentials Grant" above
            $access_token = get_access_token();
        }
        return new Management( $access_token, Config::getKey('auth0', 'domain') );
    }

    public function getUsers() {
        $mgmt_api = $this->getManagement();
        return $mgmt_api->users->search([]);
    }

    public function addUser($data) {
        $mgmt_api = $this->getManagement();
        return $mgmt_api->users->create($data);
    }

    public function updateUser($id, $data) {
        $mgmt_api = $this->getManagement();
        return $mgmt_api->users->update($id, $data);
    }

    public function getUser($id) {
        $mgmt_api = $this->getManagement();
        return $mgmt_api->users->get($id);
    }

}

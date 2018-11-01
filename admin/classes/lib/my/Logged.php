<?php

class Logged{
	private static $_account = null;

	static public function isLoggedIn() {
		if (self::$_account) {
            return true;
        }
        return false;
    }
    
	static public function isViewOnly() {
		if (isset($_SESSION['payload'])
			&& isset($_SESSION['payload']['userRole'])
			&& $_SESSION['payload']['userRole'] == 'readOnlyAdmin'
		) {
			return true;
		}
		return false;
	}

    static public function getAccount() {
								if (self::$_account) {
            return self::$_account;
        }
								if (is_null(self::$_account) && isset($_SESSION['accountId']) && strlen($_SESSION['accountId'])) {
            self::$_account = $_SESSION['accountId'];
        }
        return false;
    }
    
    static public function haveCorrectSession() {
								#if (!self::isActive()) {
								#				return false;
								#}
        if ( self::getAccount()->getSessionId() == session_id() ) {
            return true;
        }
								Site::setMessageWarning('Your session has expired! Someone logged into your account from a different location.');
								$_SESSION['accountId'] = null;
								self::$_account = null;
        return false;
				}
				
    static public function isActive() {
        if (
																is_object(self::getAccount())
																&& self::$_account->isActive()
																//&& (self::$_account->getSessionId() == session_id())
																&& self::haveCorrectSession()
												) {
            return true;
        }
								#$_SESSION['accountId'] = null;
        return false;
    }
				
}

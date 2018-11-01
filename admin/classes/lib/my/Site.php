<?php

class Site{

	private static $_unixtime = null;
	private static $_domain = null;
	private static $_title = null;
	private static $_page_title = null;
	private static $_page_description = null;
	private static $_messageTop = null;
	private static $_messageBottom = null;
	private static $_message_warning = null;
	
	private static $_is_page_noindex = false;
	
	static public function getDomain() {
					if (is_null(self::$_domain)) {
									self::$_domain = substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'],'.')+1);
					}
					return self::$_domain;
	}
	
	static public function getFullDomain() {
					return $_SERVER['SERVER_NAME'];
	}
	
	static public function getAnalytics() {
	}
	
	static public function setUnixTime($value) {
					self::$_unixtime= $value;
	}
	
	static public function getUnixTime() {
					return self::$_unixtime;
	}
	
	static public function getDate() {
					return date('Y-m-d', self::$_unixtime );
	}
	
	static public function getTime() {
					return date('H:i:s', self::$_unixtime );
	}
	
	static public function getDateTime() {
					return date('Y-m-d H:i:s', self::$_unixtime );
	}
	
	/*
	 * Title from header
	 */
	static public function setTitle($value) {
					self::$_title = $value;
	}
	
	static public function getTitle() {
					return self::$_title;
	}
	
	/*
	 * Title H1 in page
	 */
	static public function setPageTitle($value) {
					self::$_page_title = $value;
	}
	
	static public function getPageTitle() {
					return is_null(self::$_page_title) ? self::$_title : self::$_page_title;
	}
	
	/*
	 * description from header
	 */
	static public function setPageDescription($value) {
					self::$_page_description= $value;
	}
	
	static public function getPageDescription() {
					return self::$_page_description;
	}
					
	static public function getMessageTop() {
					/*
					if (is_null(self::$_messageTop) || 0 == strlen(self::$_messageTop)) {
									return self::$_title;
					}
					*/
					return self::$_messageTop;
	}
	
	static public function setMessageTop($value) {
					self::$_messageTop = $value;
	}
	
	static public function getMessageBottom() {
					return self::$_messageBottom;
	}
	
	static public function setMessageWarning($value) {
					self::$_message_warning = $value;
	}
	
	static public function getMessageWarning() {
					$message = self::$_message_warning;
	if (isset($_SESSION['message_warning'])) {
	$message .= $_SESSION['message_warning'];
	unset($_SESSION['message_warning']);
	}
	return $message;
	}
	
	static public function haveMessageWarning() {
					return !is_null(self::$_message_warning) || isset($_SESSION['message_warning']) ? true : false;
	}
	
	static public function setIsPageNoindex($value) {
					self::$_is_page_noindex = $value;
	}
	
	static public function getIsPageNoindex() {
					return self::$_is_page_noindex;
	}
	
	static public function paginate($totalCount = null, $currentPage, $elementsPerPage=20, $elementsLeftRight=3) {
		$pagination['current'] = max(1,$currentPage);
		$pagination['per'] = $elementsPerPage;
		$pagination['leftRight'] = $elementsLeftRight;
		$pagination['count'] = $totalCount;
		
		$pagination['pages'] = (int)ceil($pagination['count']/$pagination['per']);
		$pagination['start'] = max(1, $pagination['current']-$pagination['leftRight']);
		$pagination['end'] = min($pagination['start']+$pagination['leftRight']*2, $pagination['pages']);
		if ($pagination['end'] == $pagination['pages']) {
		  $pagination['start'] = max(1, $pagination['current']-$pagination['leftRight']*2);
		}
		return $pagination;
	}
				
				static public function setReferral() {
								$account = AccountQuery::create()->findOneByAffiliateCode($_GET['aff']);
								
								$accountReferral = new AccountReferral();
								$accountReferral->setDate(Site::getDateTime());
								$accountReferral->setSource(strlen($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : null);
								if (is_object($account)) {
												$accountReferral->setAccount($account);
								}
								$accountReferral->save();
				}
}
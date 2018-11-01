<?php

class Message{

				static public function getFavoriteAccountValid() {
								return 'You must <a href="" onclick="clickLogin();return false;">login</a> / '.link_to('register','accountRegister').' and have an active '
																								.link_to('money acount','accountPackage').' for using this function.';
				}
				
				static public function getAccountRecoverPasswordSend() {
								return 'Instructions regarding change of the password were sent to your e-mail address.';
				}
				
				static public function getAccountValid() {
								return  'To access these data you must <a href="" onclick="clickLogin();return false;">login</a> / '.
																link_to('register','accountRegister').'  and have an active '.link_to('money account','accountPackage')
																;
				}
				
}
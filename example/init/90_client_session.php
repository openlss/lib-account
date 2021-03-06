<?php
/**
 *  OpenLSS - Lighter Smarter Simpler
 *
 *	This file is part of OpenLSS.
 *
 *	OpenLSS is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Lesser General Public License as
 *	published by the Free Software Foundation, either version 3 of
 *	the License, or (at your option) any later version.
 *
 *	OpenLSS is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Lesser General Public License for more details.
 *
 *	You should have received a copy of the 
 *	GNU Lesser General Public License along with OpenLSS.
 *	If not, see <http://www.gnu.org/licenses/>.
 */
use \LSS\Account\Client;
use \LSS\Account\ClientSession;
use \LSS\Config;
use \LSS\Url;

if(session_id() != ''){
	//check for session
	try {
		if(ClientSession::checkLogin()){
			//register session
			$token = ClientSession::fetchByToken(ClientSession::getTokenFromSession());
			$session = array_merge(Client::fetch($token['staff_id']),$token);
			ClientSession::storeSession($session);
			unset($session,$token);
			//set tpl globals (if Tpl is available)
			if(is_callable(array('Tpl','_get'))){
				Tpl::_get()->set(array(
					 'client_name'		=>	ClientSession::get('name')
					,'client_lastlogin'	=>	date(Config::get('account.date.general_format'),ClientSession::get('last_login'))
				));
			}
		} else {
			if(server('REQUEST_URI') != Url::login()) redirect(Url::login());
		}
	} catch(Exception $e){
		ClientSession::tokenDestroy(ClientSession::getTokenFromSession());
		ClientSession::destroySession();
		redirect(Url::login());
	}
}

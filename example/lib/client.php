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
namespace LSS\Account;

abstract class Client extends \LSS\Account implements \LSS\AccountInterface {

	static $accounts_table = 'clients';
	static $account_key = 'client_id';

	public static function createParams(){
		return self::_createParams(array(
			 'is_active'	=> 1
			)
		);
	}

	public static function create($data){
		return self::_create($data
			,array('contact_is_active' => 1)
			,array(
				  'is_active'		=> 1
			 )
		);
	}

	public static function fetchAll(){
		return self::_fetchAll(array(
			  static::$accounts_table.'.is_active'		=> 1
			 )
		);
	}

	public static function fetch($client_id){
		return self::_fetch(array(
			 static::$accounts_table.'.client_id'		=> $client_id
			)
		);
	}

	public static function fetchByContact($contact_id){
		return self::_fetch(array(
			 static::$contacts_table.'.contact_id'		=> $contact_id
			)
		);
	}

	public static function fetchByEmail($email,$except=false){
		return self::_fetchByEmail(array(
			 static::$contacts_table.'.email'			=> $email
			)
			,$except
		);
	}

	public static function register($data){
		return self::create($data);
	}

}

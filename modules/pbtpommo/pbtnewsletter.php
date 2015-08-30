<?php
/*
 * @package 		OXpoMMo
 * @copyright 	(C) 2013 by Alexander Pick - ap@pbt-media.com
 * @url 			https://www.pbt-media.com
 * @license 		GNU General Public License v3, see license.txt
 */

define('SUBSCRIPTION_URL', 'http://newsletter.pbt-media.com/process.php');

class pbtnewsletter extends pbtnewsletter_parent
{
	public function send()
    {
		
        $aParams  = oxConfig::getParameter("editval");

        // loads submited values
        $this->_aRegParams = $aParams;

        $blSubscribe = oxConfig::getParameter("subscribeStatus");
		
		if($blSubscribe) {
			//subscribe
						
			$url = SUBSCRIPTION_URL; //$this->getConfig()->getConfigParam( 'pbtPommoUrl' );
			
			$fields = array(
						'Email' => urlencode($aParams['oxuser__oxusername']),
						'pommo_signup' => urlencode("true"),
					);
			
			foreach($fields as $key=>$value) { 
				$fields_string .= $key.'='.$value.'&'; 
			}
			
			rtrim($fields_string, '&');
			
			$ch = curl_init();
			
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			
			$result = curl_exec($ch);
			
			curl_close($ch);
			
		} else {
			//unsubscribe	
		}
		
		//disable Opt-In To avoid OXID Mails
		$this->getConfig()->setConfigParam( 'blOrderOptInEmail', false );
		
		return parent::send( );

    }	
	
}
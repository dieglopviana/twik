<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'javascript', 'CakePtbr.Formatacao');
	var $components = array('Auth', 'Email');
	
	function beforeFilter(){
    	if (isset($this->Auth)){
    		// Seta a action que fará o login
    		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
	        
	        // Seta a mensagem de erro de login do authComponent
	        $this->Auth->loginError = 'O login ou a senha foram digitados incorretamente!';
	        
	        // Onde o authComponent vai redirecionar depois do logout
            $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
	        
	        // Seta o autoRedirect do authComponent para false
            $this->Auth->autoRedirect = false;
            
            // Seta a mensagem de erro de permissão do authComponent
            $this->Auth->authError = 'Você não tem permissão para acessar essa área.';
            
            // Seta o tipo de autorização
            $this->Auth->authorize = 'controller';
    	}
    }
    
    function isAuthorized(){
        if(!empty($this->params['admin']) && $this->Auth->user('admin') != 1){
            return false;
        }
        return true;
    }    
	
	function _sendEmail($data) {
        if(!empty($data)) {
			/* SMTP Options */
			$this->Email->smtpOptions = array(
				'port'=>'25',
				'timeout'=>'30',
				'host' => 'smtp.pontom.com',
				'username'=>'twik=pontom.com',
				'password'=>'teste123'
			);
			
			# /* Define a forma de entrega */
			$this->Email->delivery = 'smtp';
        	
        	// Required parameter, will use app default if not set
            if(!empty($data['from'])){
                $this->Email->from = trim($data['from']);
            } else {
                $this->Email->from = 'Twik <twik@pontom.com>';
            }

            // Required parameter, will return false if not set
            if(!empty($data['to'])){
                $this->Email->to = trim($data['to']);
                $this->set('recipient', $this->Email->to);
            }else{
                $this->log('_sendMail(), the \'to\' parameter cannot be empty');
                return false;
            }

            // Required parameter, will return false if not set
            if(!empty($data['subject'])){
                $this->Email->subject = trim($data['subject']);
            }else{
                $this->log('_sendMail(), the \'subject\' parameter cannot be empty');
                return false;
            }

            // Required parameter, will return false if not set
            if(!empty($data['template'])){
                $this->Email->template = $data['template'];
            }else{
                $this->log('_sendMail(), the \'template\' parameter cannot be empty');
                return false;
            }

            // Optional, I will use both if main conf/passed data empty
            if(!empty($data['sendAs'])){
                $this->Email->sendAs = $data['sendAs'];
            }else{
                $this->Email->sendAs = 'both';
            }

            // Optional, I will use default if empty
            if(!empty($data['layout'])){
                $this->Email->layout = $data['layout'];
            }else{
                $this->Email->layout = 'default';
            }

            // Optional, can be empty
            if(!empty($data['cc'])){
                if(is_array($data['cc'])){
                    foreach($data['cc'] as $key => $address){
                        // Trim address from any whitespace
                        $data['cc'][$key] = trim($address);
                    }
                }else{
                    $this->Email->cc = trim($data['cc']);
                }
            }

            // Optional, can be empty
            if(!empty($data['bcc'])){
                if(is_array($data['bcc'])){
                    foreach($data['bcc'] as $key => $address){
                        $data['bcc'][$key] = trim($address);
                    }
                }else{
                    $this->Email->cc = trim($data['bcc']);
                }
            }

            // Set the data to template
            $this->set('data', $data);

            // Send the email
            if($this->Email->send()){
                return true;
            }else{
                if($this->Email->delivery == 'smtp'){
                    $this->log(sprintf('_sendMail(), sending email failed. %s', $this->Email->smtpError));
                }else{
                    $this->log('_sendMail(), sending email failed.');
                }
                return false;
            }
        }else{
            $this->log('_sendMail(), data parameter required.');
            return false;
        }
    }
}
?>
<?php

namespace CustomLib\Service;

use Zend\Math\Rand;

class ApiSecurity 
{
    protected $AppKey;
    
    /**
     * 
     * @param string $appKey
     * @return \SureSlotLib\ApiSecurity
     */
    public function setAppKey($appKey)
    {
        $this->AppKey = $appKey;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getSalt()
    {
        return $this->AppKey;
    }
    
    /**
     * Function to generate a random key.
     * 
     * @return \Zend\PartyAppLib\ApiSecurity
     */
    public function generateKey()
    {
        // New key Generation.
        $key='';
        $integer = Rand::getInteger(111, 999);
        $string = Rand::getString(32,'abcdefghijklmnopqrstuvwxyz',true);
        $key = $integer.$string;
        $this->setAppKey($key.Rand::getInteger(111, 999));
        return $this;        
    }
    
    

/**
     * Function to generate new password using algo1
     * 
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function firstPwdAlgo($password = '',$salt = '')
    {
      $newPassword = sha1($password.$salt);
      return $newPassword;
    }
    
    /**
     * Function to generate new password using algo2.
     * 
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function secondPwdAlgo($password = '',$salt = '')
    {
        $newPassword = md5($password.$salt);
        return $newPassword;
    }
    
    
    public function authenticatUser($userPassward ='',
                                        $databasePassword ='',
                                           $salt = '',
                                            $algo= 'firstPwdAlgo')
    {
        $newPassword = $this->$algo($userPassward,$salt);
        if($newPassword == $databasePassword ) {
            return true;
        }else {
            return false;
        }
    }
}


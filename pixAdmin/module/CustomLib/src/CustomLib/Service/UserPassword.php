<?php

/**
 * UserPassword class
 * Manages User Password Configurations
 *
 * @category customLib
 * @package Service
 */
namespace CustomLib\Service;

use Zend\Crypt\Password\Bcrypt;

/**
 * UserPassword class
 * Manages User Password Configurations
 *
 * @category customLib
 * @package Service
 *         
 */
class UserPassword
{
    public $salt = 'aUJGgadjasdgdj';
    public $method = 'sha1';
    
    /**
     * Constructor
     *
     * @access public
     *        
     * @param string $method
     *            // Encryption method
     * @return void
     */
    public function __construct($salt = null,$method = null)
    {
        if (!is_null($method)) {
            $this->method = $method;
        }
        
        if (!is_null($salt)) {
            $this->salt = $salt;
        }
    }
    
    /**
     * Create Password
     *
     * @access public
     *        
     * @param string $password
     *            User Password
     * @return string
     */
    public function create($password)
    {
        return sha1($password.$this->salt);
    }
    
    /**
     * Validate the user password
     *
     * @access public
     *        
     * @param string $password
     *            // Password string
     *            
     * @param string $hash
     *            // Hash string
     *            
     * @return boolean
     */
    public function verify($password, $hash)
    {
            return $hash = md5($password.$this->salt);
       
    }
}

?>

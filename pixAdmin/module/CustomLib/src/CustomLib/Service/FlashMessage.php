<?php

/**
* FlashMessage class
* Manages flash messages
*
* @category Application
* @package  View\Helper
*
*/
namespace CustomLib\Service;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * FlashMessage class
 * Manages flash messages
 *
 * @category Application
 * @package View\Helper
 *         
 */
class FlashMessage extends AbstractHelper
{
    protected $_request;
    protected $_flashMessenger;
    
    /**
     * Constructor
     *
     * @access public
     * @param Request $request
     *            Request object
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }
    /**
     * Set the flash message
     *
     * @access public
     * @param String $flashMessenger
     *            Flash message
     * @return void
     */
    public function setFlashMessenger($flashMessenger)
    {
        $this->_flashMessenger = $flashMessenger;
    }
    
    /**
     * Return the flash message
     *
     * @access public
     * @return String Flash message content
     */
    public function __invoke()
    {
        $namespaces = array('error', 'success', 'info', 'warning');    
        $messageString = '';
        
        foreach ($namespaces as $ns) {
            
            $this->_flashMessenger->setNamespace($ns);
            
            $messages = $this->_flashMessenger->getCurrentMessages();
           		
            if (!$messages)
                continue;
            $class = ($ns == "error")?"danger":$ns;
            $messageString .= "<div class='alert alert-".$class."'>
            <a class='close' data-dismiss='alert'>×</a><strong>".ucfirst($ns)."!! </strong>" . 
            implode('<br />', $messages) .
                 '</div>';
        }
        return $messageString;
    }
}
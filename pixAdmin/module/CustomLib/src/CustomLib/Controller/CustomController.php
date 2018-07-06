<?php

/**
 * CustomController class
 * Extended by all the controllers for common functionalities
 *
 * @category CustomLib
 * @package  Controller
 */
namespace CustomLib\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use CustomLib\Service\S3;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\Validator\File\IsImage;
use Zend\InputFilter\FileInput;
use CustomLib\Service\ImageManipulator;

class CustomController extends AbstractActionController
{

    private $_pickupcentreTable;
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        // $this->_error = new customError();
        // $this->_utility = new customUtility();
    }

    /**
     * Get error instance
     *
     * @access public
     * @return \CustomLib\Service\customError
     */
    public function getErrorInstance()
    {
        return $this->_error;
    }

    /**
     * Get utility instance
     *
     * @access public
     * @return \CustomLib\Service\customUtility
     */
    public function getUtilityInstance()
    {
        return $this->_utility;
    }

    /**
     * Translate string
     *
     * @access protected
     * @param string $msg
     *            // message string
     * @return string
     */
    protected function translate($msg)
    {
        $translate = $this->getServiceLocator()
            ->get('viewhelpermanager')
            ->get('translate');
        return $translate($msg);
    }

    /**
     * Function to find action for module.
     *
     * @return String.
     */
    public function submenu()
    {
        return $this->_module;
    }

    /**
     * Get logged in user Id
     *
     * @access public
     * @return integer
     */
    public function getLoggedInUserId()
    {
        $session = new Container('User');
        $loginUserId = $session->offsetGet('userId');
        return $loginUserId;
    }
    
    /**
     * Get logged in usr State Id
     */
    public function getLoggedInUserState()
    {
        $session = new Container('User');
        $loginUserState = $session->offsetGet('userState');
        return $loginUserState;
    }
    
    /**
     * Function to get the language
     *
     * @return Ambigous <\Zend\Session\mixed, NULL, unknown>
     */
    public function getLang()
    {
        $appSess = new Container('User');
        if ($appSess->offsetExists('lang')) {
            return $appSess->offsetGet('lang');
        } else {
            $appSess->offsetSet('lang', 'de');
            return $appSess->offsetGet('lang');
        }
    }

    /**
     * Function to check user is login or not
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $module = $this->findModule($this->params('controller'), $this->params('action'));
        $userDetail = $this->getLoggedInUserId();
        if (is_null($userDetail)) {
            if ($this->params('action') != 'login' && $this->params('action') != 'register'
                && $this->params('action') != 'change-password' && $this->params('action') != 'reset-password'
                ) {
                $this->redirect()->toUrl("/application/index/login");
            }
        } else {            
            $session = new Container('User');
            $viewModel = $e->getViewModel();
            $viewModel->moduleName = $module;
            $viewModel->actionName = $this->params('action');
            $viewModel->moduleId = $this->params('id');
            $viewModel->userId = $userDetail;
            $viewModel->userName = $session->offsetGet('userName');
            $viewModel->userRole = $session->offsetGet('userRole');
            $viewModel->userState = $session->offsetGet('userState');
            $viewModel->userRoleId = $session->offsetGet('userRoleId');
            $viewModel->appMvc = $this;
            $config = $this->getServiceLocator ()->get ( 'config' );
            $bucketSetting = $config['settings']['S3BUCKET'];
            $viewModel->serverUrl = $bucketSetting['BUCKETURL'];
//             echo '<pre>'; print_r($this->params('moduleId')); die;
       if($session->offsetGet('userRole') =='3' && ($this->params('action') !='search-retail-data'
                && $this->params('action') !='get-retailer'
                && $this->params('action') !='search-retailer-documents'
                && $this->params('action') !='get-order-by-retailer'
                && $this->params('action') !='get-order-detail'
                &&  $this->params('action') != 'search')){
                $this->redirect()->toUrl('/retailers/search');
       }else{
            if ($this->params('action') == 'login') {
                if($session->offsetGet('userRole') =='1'){
                   return $this->redirect()->toUrl('/application/index/dashboard');
                }elseif($session->offsetGet('userRoleId') =='5' || $session->offsetGet('userRoleId') =='6'){
                   return $this->redirect()->toUrl('/rpcmain/index');
                }elseif($session->offsetGet('userRole') =='6'){
                   return $this->redirect()->toUrl('/super-retailer/dashboard');
                }else{
                   return $this->redirect()->toUrl('/application/index/dashboard');
                }
            }
            if ($module == 'Application' && $this->params('action') == 'index') {
                if($session->offsetGet('userRole') =='1'){
                    return $this->redirect()->toUrl('/application/index/dashboard');
                }elseif($session->offsetGet('userRoleId') =='5' || $session->offsetGet('userRoleId') =='6'){
                   return $this->redirect()->toUrl('/rpcmain/index');
                }elseif($session->offsetGet('userRole') =='6'){
                   return $this->redirect()->toUrl('/super-retailer/dashboard');
                }else{
                return $this->redirect()->toUrl('/application/index/dashboard');
                }
            }
           }
        }
        return parent::onDispatch($e);
    }

    /**
     * Function to find module and set the head title.
     *
     * @param String $controller            
     * @param String $action            
     */
    public function findModule($controller, $action)
    {
        $controllerParam = explode('\\', $controller);
        $viewHelperManager = $this->getServiceLocator()->get('viewHelperManager');
        $headTitleHelper = $viewHelperManager->get('headTitle');
        $headTitleHelper->append($controllerParam[0]);
        return $controllerParam[0];
    }

    /**
     *
     * @param unknown $paginator            
     * @param string $page            
     * @param string $counter            
     * @return multitype:string Ambigous <number, string> number unknown
     */
    protected function paginationToArray($paginator, $page = '', $counter = '')
    {
        $paginator->setCurrentPageNumber((int) $page);
        $paginator->setItemCountPerPage($counter);
        $totalCount = $paginator->getTotalItemCount();
        $lastPage = ceil($totalCount / $counter);
        $fullArray = \Zend\Stdlib\ArrayUtils::iteratorToArray($paginator); // $paginator->getIterator()->toArray();
        $nextPage = 0;
        if ($page == $lastPage || $lastPage == 0) {
            $nextPage = $page;
        } else {
            $nextPage = $page + 1;
        }
        return array(
            'page' => $page,
            'nextPage' => $nextPage,
            'allData' => $fullArray,
            'lastRecord' => $lastPage,
            'pageCount' => $counter,
            'totalCount' => $totalCount
        );
    }
    
    /**
     *
     * @param unknown $filename
     * @return resource|string
     */
    function imagecreatefromfile($filename)
    {
        switch (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($filename);
                break;
    
            case 'png':
                return imagecreatefrompng($filename);
                break;
    
            case 'gif':
                return imagecreatefromgif($filename);
                break;
    
            default:
                return 'File "' . $filename . '" is not valid jpg, png or gif image.';
                break;
        }
    }
    /**
     *
     * Function to upload files into s3 bucket
     *
     * @param string $filePath full path of the file.
     * @param string $fileName only file name
     * @param number $type flag for image and vedio files if image $type = 1
     * 											  and for for video $type =2
     *
     * for accessing the file use this URL
     *
     *  http://bucketname.s3.amazonaws.com/filename.ext
     */
    public function putIntoS3Bucket($filePath = '',$fileName ='')
    {
        // Bucket settings.
        $config = $this->getServiceLocator ()->get ( 'config' );
        $bucketSetting = $config['settings']['S3BUCKET'];
        $AWSkey = $bucketSetting['AWSKEY'];
        $AWSSecret = $bucketSetting['AWSSECRET'];
         
        $s3 = new S3($AWSkey, $AWSSecret);
         
        // create bucket for all files.
        $bucketName = $bucketSetting['FILEBUCKET'];
        $s3->putBucket($bucketName,S3::ACL_PUBLIC_READ);
         
        //move the file
        if ($s3->putObjectFile($filePath, $bucketName, $fileName, S3::ACL_PUBLIC_READ)) {
            return  true;
        }else{
            return  false;
        }
    }
    
    /**
     * Function to center a Image
     *
     *@param string file path.
     * @param string $fileName
     */
    public function centerImage($filePath = '', $fileName = '')
    {
        $file = $filePath.$fileName;
         
        $img = new ImageManipulator($file);
        $w = $img->getWidth();
        $h = $img->getHeight();
        $r = 100;
        if($w > $h){
            $r = $h;
        } else {
            $r = $w;
        }
         
        $centreX = round($img->getWidth() / 2);
        $centreY = round($img->getHeight() / 2);
         
        $x1 = round($centreX - ($r/2),0);
        $y1 = round($centreY - ($r/2),0);
         
        $x2 = round($centreX + ($r/2),0);
        $y2 = round($centreY + ($r/2),0);
         
        $img->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
         
        $destinationPath = sha1(time (). ceil((rand(0,10000)))).'.jpg';
        $img->save($filePath.$destinationPath);
         
        return $destinationPath;
         
    }
    
    
    /**
     * Function to reSize Image
     *
     * @param string $fileName
     * @param number $width
     * @param number $height
     */
    public function reSizeImageForChat($filePath = '', $fileName = '',$w = 320, $h = 568,$compress = 0)
    {
        $file = $filePath.$fileName;
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
         
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    
        //     	$newwidth = $w;
        //     	$newheight = $h;
    
        $src = $this->imagecreatefromfile($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        $destinationPath = substr($fileName,0,strpos($fileName ,'.')).'-thumb.jpg';
    
        if($compress){
            imagejpeg($dst, $filePath.$destinationPath,85);
        } else {
            //    		imagejpeg($dst, $filePath.$destinationPath);
            $newCreatedFile = $this->imagecreatefromfile($dst);
            file_put_contents($filePath.$destinationPath, $newCreatedFile);
            //    		imagejpeg($dst, $filePath.$destinationPath);
        }
    
        return $destinationPath;
    }
    
    /**
     * 
     * @param unknown $mailOptions
     * @param string $con
     * @return boolean
     */
    public function sendEmail($mailOptions = array(), $con = "") {
        $config = $this->getServiceLocator ()->get ( 'config' );
        $config = $config['settings'];
        $smtpName = $config ['EMAIL'] ['SMTP_NAME'];
        $smtpHost = $config ['EMAIL'] ['SMTP_HOST'];
        $smtpPort = $config ['EMAIL'] ['SMTP_PORT'];
        $smtpConnectionClass = $config ['EMAIL'] ['SMTP_CONNECTION_CLASS'];
        $smtpUsername = $config ['EMAIL'] ['SMTP_USERNAME'];
        $smtpPassword = $config ['EMAIL'] ['SMTP_PASSWORD'];
        $smtpSsl = $config ['EMAIL'] ['SMTP_SSL'];
        $mailBody = $config ['EMAIL'] ['BODY'];
        $mailFrom = $config ['EMAIL'] ['FROM'];
        $mailSubject = $config ['EMAIL'] ['SUBJECT'];
        $mailFromNickName = $config ['EMAIL'] ['FROM_NICK_NAME'];
        $mailTo = $config ['EMAIL'] ['TO'];
        $mailSenderType = $config ['EMAIL'] ['SMTP_SENDER_TYPE'];
    
        if (array_key_exists ( 'mailTo', $mailOptions )) {
            $mailTo = $mailOptions ['mailTo'];
        }
        if (array_key_exists ( 'mailCc', $mailOptions )) {
            $mailCc = $mailOptions ['mailCc'];
        }
    
        if (array_key_exists ( 'mailFrom', $mailOptions )) {
            $mailFrom = $mailOptions ['mailFrom'];
        }
        if (array_key_exists ( 'mailFromNickName', $mailOptions )) {
            $mailFromNickName = $mailOptions ['mailFromNickName'];
        }
        if (array_key_exists ( 'mailSubject', $mailOptions )) {
            $mailSubject = $mailOptions ['mailSubject'];
        }
        if (array_key_exists ( 'mailBody', $mailOptions )) {
            $mailBody = $mailOptions ['mailBody'];
        }
        if (array_key_exists ( 'sender_type', $mailOptions )) {
            $mailSenderType = $mailOptions ['sender_type'];
        }
         
         
         
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        // Additional headers
        $headers .= "From:".$mailFrom;
         
         
        $emailSend = mail($mailTo,$mailSubject,$mailBody,$headers);
         
         
        return $emailSend;
    }
    
     /**
     * Function to find module and set the head title.
     *
     * @param String $controller            
     * @param String $action            
     */
    public function fncGetDropDown($arrData = array())
    {
        $codeMasterArr = $this->getPickupcentreTable()->fncGetDropDown($arrData);
        return $codeMasterArr;
    }
    
    /**
     * 
     * @return Ambigous <object, multitype:, \Pickupcentre\Model\PickupcentreTable>
     */
    public function getPickupcentreTable()
    {
        if (! $this->_pickupcentreTable) {
            $sm = $this->getServiceLocator();
            $this->_pickupcentreTable = $sm->get('Pickupcentre\Model\PickupcentreTable');
        }
        return $this->_pickupcentreTable;
    }
    
    /**
     * 
     * @param unknown $listType
     * @return multitype:unknown
     */
    public function dropDownlist($listType){
        $drpdwn = array();
        $drpdwn[''] = '';
        if($listType == 'apply_to_region'){
            $drpdwn['all'] = ' All ';
        }
        $codeMaster = $this->getPickupcentreTable()->getData('code_master',array('where' => array('alias' => $listType)));
        $list = $this->getPickupcentreTable()->getData('code_master_values', array('where' => array('code_master_id' => $codeMaster[0]['id'])));
        if(!empty($list)){
            foreach ($list as $val){
                $drpdwn[$val['id']] = $val['name'];
            }
        }
        return $drpdwn;
    }
    
    /**
     * 
     * @param string $filePath
     * @param string $fileName
     * @param number $w
     * @param number $h
     * @param number $compress
     * @param string $customName
     * @return string
     */
    public function reSizeImage($filePath = '', $fileName = '',$w = 320, $h = 568,$compress = 0, $customName = '')
    {
        $file = $filePath.$fileName;
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
    
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    
        $src = $this->imagecreatefromfile($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        if(empty($customName)) {
            $destinationPath = sha1(time() . ceil((rand(0, 10000)))) . '.jpg';
        } else {
            $destinationPath = $customName;
        }
    
        if($compress){
            imagejpeg($dst, $filePath.$destinationPath,$compress);
        }else {
            imagejpeg($dst, $filePath.$destinationPath);
        }
         
    
        return $destinationPath;
    }
    
    /**
     * 
     * @param array $smsData
     */
    public function sendSMS($smsData = array())
    {
        $config = $this->getServiceLocator ()->get ( 'config' );
        $config = $config['SMSGateway'];
    
        $ch = curl_init();
        $user = $config['user'];
        $receipientno = $smsData['mobile'];
        $senderID = $config['senderId'];
        $msgtxt = $smsData['msg'];
        curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
        $buffer = curl_exec($ch);
            curl_close($ch);
            return true;
        }
    
    /**
     * 
     * @param type $number
     * @return boolean
     */
    public function convert_number_to_words($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        
        if (!is_numeric($number)) {
            return false;
        }
        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }
        
        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));                
                $numBaseUnits = (int) ($number / $baseUnit);                
                $remainder = $number % $baseUnit;                
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }                
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        
        return $string;
    }

    
    /**
     * Function to push data in job queue.
     * 
     * @param unknown_type $data
     */
    public function sendPushNotification($data=array())
    {
        
        $pushController = $this->getServiceLocator()->get('Pushnotification\Controller\PushnotificationController');
        $pushController->fndSendPush($data);
    }
    
    /**
     * 
     * @return mixed|NULL|\Zend\Session\Storage\StorageInterface
     */
    public function getLoggedInUserType()
    {
        $session = new Container('User');
        $loginUserState = $session->offsetGet('userRole');
        return $loginUserState;
    }
    
    /**
     * 
     * @return mixed|NULL|\Zend\Session\Storage\StorageInterface
     */
    public function getLoggedInUserRoleId()
    {
        $session = new Container('User');
        $loginUserState = $session->offsetGet('userRoleId');
        return $loginUserState;
    }
    
    /**
     * 
     * @param unknown $stateId
     * @return unknown
     */
    public function getRPCByState(){
        $rpc = $this->getPickupcentreTable()->getData('rpc', array('where' => array('state' => $this->getLoggedInUserState())));
        
        return $rpc[0]['id'];
    }
}

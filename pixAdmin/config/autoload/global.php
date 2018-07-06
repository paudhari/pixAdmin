<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'CustomLib\Service\AppHttpAuth' => 'CustomLib\Service\AppHttpAuth'
        )
    ),
    
    'secure_password' => array(
        'salt' => 'abcdefghijklmnopqrestuvwxyz',
        'cost' => 14
    ),
    'settings' => array(
            "S3BUCKET" => array(
            'AWSKEY' => 'AKIAJ3CUTO4S4M4XRKWQ',
            'AWSSECRET' => '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',
            'FILEBUCKET' => 'inclusosol.com',
            'BUCKETURL' => 'http://pixapi.digvijayjain.com/uploadedFiles/',
            "TEMPPATH" => __DIR__.'/../../public/uploadedFilesFiles/',
            ),
        "COMMON_SALT" => '757jyetxheuprxagcivkzlwkgszzphkffov427',
        ),
);

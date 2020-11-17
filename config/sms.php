<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Default SMS Gateway
    |--------------------------------------------------------------------------
    |
    | The Default SMS gateway name
	| Example : "smsgw.net" , "mobily.ws" or any other you define here
	| You can override the default gateway at request
    |
    */
    'default' => 'mobily.ws',
    /*
    |--------------------------------------------------------------------------
    | SMS Gateway Setup
    |--------------------------------------------------------------------------
    |
    | Here you may configure the gateway setup which includes the API links,
    | parameters, method (get, post) .
    | And setup the account credentials 
    |
    */
    'gateways' => [
        'AlfaCell' => [
            'method' => 'post',
            'senderParameter' => 'sender',
            'messageParameter' => 'msg',
            'userParameter' => 'apiKey',
            'passwordParameter' => 'apiKey',
            'recipientsParameter' => 'numbers',
            'successCode' => '1',
            'dateFormat' => 'm/d/Y',
            'dateParameter' => 'dateSend',
            'timeFormat' => 'H:i:s',
            'timeParameter' => 'timeSend',
            'numbersSeparator' => ',',
            'parameters' => [
                'sender' => '', // Alfacell Sender Name
                'apiKey' => '', // Alfacell API key
                'applicationType' => '68',
                'domainName' => '',
                'lang' => 3
            ],
            'links' => [
                'getCredit' => 'http://www.mobily.ws/api/balance.php',
                'sendBulk' => 'http://www.mobily.ws/api/msgSend.php'
            ],
        ], 
        'mobily.ws' => [
            'method' => 'post',
            'senderParameter' => 'sender',
            'messageParameter' => 'msg',
            'userParameter' => 'mobile',
            'passwordParameter' => 'password',
            'recipientsParameter' => 'numbers',
            'successCode' => '1',
            'dateFormat' => 'm/d/Y',
            'dateParameter' => 'dateSend',
            'timeFormat' => 'H:i:s',
            'timeParameter' => 'timeSend',
            'numbersSeparator' => ',',
            'parameters' => [
                'sender' => '', // Mobily.ws Sender Name
                'mobile' => '', // Mobily.ws Account Mobile (Username)
                'password' => '', // Mobily.ws Password
                'deleteKey' => 90,
                'resultType' => 1,
                'viewResult' => 1,
                'MsgID' => rand(00000, 99999),
                'applicationType' => '68',
                'lang' => 3
            ],
            'links' => [
                'getCredit' => 'http://www.mobily.ws/api/balance.php',
                'sendBulk' => 'http://www.mobily.ws/api/msgSend.php'
            ],
        ],
        'smsgw.net' => [
            'method' => 'post',
            'senderParameter' => 'strTagName',
            'messageParameter' => 'strMessage',
            'userParameter' => 'strUserName',
            'passwordParameter' => 'strPassword',
            'recipientsParameter' => 'strRecepientNumbers',
            'successCode' => '1',
            'dateTimeFormat' => 'YmdHi',
            'dateTimeParameter' => 'sendDateTime',
            'numbersSeparator' => ';',
            'parameters' => [
                'strUserName' => '', // smsgw.net Sender Name
                'strPassword' => '', // smsgw.net Password
                'strTagName' => '',  // smsgw.net Tag Name
            ],
            'links' => [
                'getCredit' => 'http://api.smsgw.net/GetCredit',
                'sendBulk' => 'http://api.smsgw.net/SendBulkSMS'
            ],
        ],
        'shamelsms.net' => [
            'method' => 'get',
            'senderParameter' => 'sender',
            'messageParameter' => 'message',
            'userParameter' => 'username',
            'passwordParameter' => 'password',
            'recipientsParameter' => 'mobile',
            'successCode' => '1',
            'dateFormat' => 'm/d/Y',
            'dateParameter' => 'date',
            'timeFormat' => 'H:i:s',
            'timeParameter' => 'time',
            'numbersSeparator' => ',',
            'parameters' => [
                'sender' => '',
                'username' => '', 
                'password' => '',
                'unicodetype' => 'u'
            ],
            'links' => [
                'getCredit' => 'http://www.shamelsms.net/api/users.aspx?code=7&',
                'sendBulk' => 'http://www.shamelsms.net/api/httpSms.aspx'
            ],
        ],
        'malath.net.sa' => [
            'method' => 'get',
            'senderParameter' => 'sender',
            'messageParameter' => 'message',
            'userParameter' => 'username',
            'passwordParameter' => 'password',
            'recipientsParameter' => 'mobile',
            'successCode' => '0',
            'dateFormat' => 'm/d/Y',
            'dateParameter' => 'dateSend',
            'timeFormat' => 'H:i:s',
            'timeParameter' => 'timeSend',
            'numbersSeparator' => ',',
            'parameters' => [
                'sender' => '', 
                'username' => '', 
                'password' => '', 
                'unicode' => 'U'
            ],
            'links' => [
                'getCredit' => 'http://sms.malath.net.sa/api/getBalance.aspx',
                'sendBulk' => 'http://sms.malath.net.sa/httpSmsProvider.aspx'
            ],
        ],
        "unifonic.com" => [            
            'method' => 'post',
            'senderParameter' => 'SenderID',
            'messageParameter' => 'Body',
            'userParameter' => 'AppSid',
            'recipientsParameter' => 'Recipient',
            'successCode' => '0',
            'dateFormat' => 'yyyy-mm-dd HH:mm:ss',
            'dateParameter' => 'TimeScheduled',
            'timeFormat' => '',
            'timeParameter' => '',
            'numbersSeparator' => ',',
            'parameters' => [
                'sender' => '',
                'AppSid' => '',
                'unicode' => 'U'
            ],
            'links' => [
                'getCredit' => 'https://api.unifonic.com/rest/Account/GetBalance',
                'sendBulk' => 'https://api.unifonic.com/rest/Messages/SendBulk'
            ],
        ]
    ],
];
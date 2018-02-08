<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
        'alipay' => [
            'driver' => 'Alipay_Express',
            'options' => [
                'partner' => '2088521146685204',
                'key' => '2016111802957971',
                'sellerEmail' =>'weknet@163.com',
                'returnUrl' => 'api/webReturn',
                'notifyUrl' => 'api/webNotify'
            ]
        ]
	]

];
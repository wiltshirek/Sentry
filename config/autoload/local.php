<?php
return array(
    'db' => array(
        'username' => 'kwilt_sentry',
        'password' => 'socksock',
    
    ),
	'doctrine' => array(
				'connection' => array(
						'orm_default' => array(
								'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
								'params' => array(
										'host'     => 'havevisiontechnologies.com',
										'port'     => '3306',
										'user'     => 'kwilt_sentry',
										'password' => 'socksock',
										'dbname'   => 'kwilt_sentry',
								)
						)
				)
		),

);

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$router->get('/', ['as' => 'stats.index', 'uses' =>'StatController@index']);
$router->post('/stats',['as' => 'stats.store', 'uses' => 'StatController@store' ]);

$router->get('/stats/reset',['as' => 'stats.reset', 'uses' => 'StatController@reset' ]);
$router->get('/stats/analyze',['as' => 'stats.analyze', 'uses' => 'StatController@analyze' ]);

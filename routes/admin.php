<?php

use ClimbingCard\Services\Route;

Route::setNamespace('ClimbingCard\Http');

Route::adminPage(
	__(
		'Climbing Card',
		'climbingcard'
	),
	'climbingcard',
	'Admin\CardsController@index',
	['position' => 40, 'capability' => 'read']
);

Route::adminSubPage(
	__('Settings',  'climbingcard'),
	'climbingcard',
	'settings',
	'Admin\SettingsController@index',
	['position' => 60, 'capability' => 'read']
);

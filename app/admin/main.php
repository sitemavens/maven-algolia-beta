<?php

namespace MavenEvents\Admin;

// Exit if accessed directly 
if ( ! defined( 'ABSPATH' ) )
	exit;

class Main {

	public static function init() {


		$eventController = new \MavenEvents\Admin\Wp\EventController();
		$eventController->init();

		$venueController = new \MavenEvents\Admin\Wp\VenueController();
		$venueController->init();
	}

	  

}

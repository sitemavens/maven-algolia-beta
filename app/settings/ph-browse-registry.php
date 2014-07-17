<?php

namespace PhBrowse\Settings;

use \Maven\Settings\Option;

// Exit if accessed directly 
if ( !defined( 'ABSPATH' ) )
	exit;

class PhBrowseRegistry extends \Maven\Settings\WordpressRegistry {

	/**
	 * 
	 * @var StatsRegistry 
	 */
	private static $instance;

	protected function __construct () {

		parent::__construct();
	}

	/**
	 *
	 * @return \PhBrowse\Settings\PhBrowseRegistry
	 */
	static function instance () {
		if ( !isset( self::$instance ) ) {

			$adminEmail = get_bloginfo( 'admin_email' );


			$defaultOptions = array(
				new Option(
						"emailNotificationsTo", "Send email notifications to", $adminEmail, ''
				),
				new Option(
						"actions", "Actions", array(), ''
				) 
			);

			self::$instance = new self( );
			self::$instance->setOptions( $defaultOptions );
		}

		return self::$instance;
	}

	function getEmailNotificationsTo () {

		return $this->getValue( 'emailNotificationsTo' );
	}

	public function getActions () {

		return $this->getValue( 'actions' );
	}

	public function isActionEnabled ( $actionName ) {
		$actions = $this->getActions();

		return ( isset( $actions[ $actionName ] ) );
	}
  

	public function getBowerComponentUrl () {
		return $this->getPluginUrl() . "bower_components/";
	}

	public function getScriptsUrl () {
		return $this->getPluginUrl() . "scripts/";
	}
	
	public function getFrontScriptsUrl () {
		return $this->getPluginUrl() . "scripts/front/";
	}
	
	public function getStylesUrl(){
		return $this->getPluginUrl() . "styles/";
	}

}

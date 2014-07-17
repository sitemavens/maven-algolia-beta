<?php

/*
  Plugin Name: Peter Harrington Browse
  Plugin URI:
  Description:  
  Author: SiteMavens.com
  Version: 0.1
  Author URI: http://www.sitemavens.com/
 */

namespace PhBrowse;

use Maven\Core\Loader;
 
//If the validation was already loaded
if ( !class_exists( 'MavenValidation' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'maven-validation.php';
}

// Check if Maven is activate, if not, just return.
if ( \MavenValidation::isMavenMissing() )
	return;



//Added some classes here, because there are issues with ReflectionClass on Settings controller , 'core/actions','core/domain/event-prices'
Loader::load( plugin_dir_path( __FILE__ ), array( 'settings/ph-browse-registry' ) );


// Instanciate the registry and set all the plugins attributes
$registry = Settings\PhBrowseRegistry::instance();

$registry->setPluginDirectoryName( "ph-browse" );
$registry->setPluginDir( plugin_dir_path( __FILE__ ) );
$registry->setPluginUrl( defined( 'DEV_ENV' ) && DEV_ENV ? WP_PLUGIN_URL . "/ph-browse/" : plugin_dir_url( __FILE__ )  );
$registry->setPluginName( 'PH Browse' );
$registry->setPluginShortName( 'me' );
$registry->setPluginVersion( "0.1" );
$registry->setRequest( new \Maven\Core\Request() );

$registry->init();

/**
 * We need to register the namespace of the plugin. It will be used for autoload function to add the required files. 
 */
Loader::registerType( "PhBrowse", $registry->getPluginDir() );

Loader::load( $registry->getPluginDir(), 'core/installer.php' );

/**
 * 
 * Instantiate the installer 
 *
 * * */
$installer = new \PhBrowse\Core\Installer();
register_activation_hook( __FILE__, array( $installer, 'install' ) );
register_deactivation_hook( __FILE__, array( $installer, 'uninstall' ) );

/**
 *  Create the Director and the plugin
 */
$director = \Maven\Core\Director::getInstance();

$director->createPluginElements( $registry );

Front\Main::init();
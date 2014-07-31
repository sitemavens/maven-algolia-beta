<?php

namespace PhBrowse\Front;

// Exit if accessed directly 
if ( !defined( 'ABSPATH' ) )
	exit;

class Main {

	private static $instance;

	public static function init () {

		if ( !self::$instance ) {
			self::$instance = new Main();
		}

		\Maven\Core\HookManager::instance()->addEnqueueScripts( array( self::$instance, 'registerScripts' ));
	}

	public function registerScripts () {
		$registry = \PhBrowse\Settings\PhBrowseRegistry::instance();
		
		//TODO: Esto hay que quitarlo, quizas agregarle un filtro para que solo se levante en paginas 
		// que sea necesario.
		if ( is_page( 'browse' ) || is_tax( 'mvnb_category' )) {

			if ( $registry->isDevEnv() ) {
				wp_enqueue_script( 'angular', $registry->getBowerComponentUrl() . "angular/angular.js", array('jquery','jquery-ui-core'), $registry->getPluginVersion() );
				wp_enqueue_script( 'bootstrap', $registry->getBowerComponentUrl() . "bootstrap/dist/js/bootstrap.js", array('jquery'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-resource', $registry->getBowerComponentUrl() . "angular-resource/angular-resource.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-cookies', $registry->getBowerComponentUrl() . "angular-cookies/angular-cookies.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-sanitize', $registry->getBowerComponentUrl() . "angular-sanitize/angular-sanitize.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-route', $registry->getBowerComponentUrl() . "angular-route/angular-route.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-bootstrap', $registry->getBowerComponentUrl() . "angular-bootstrap/ui-bootstrap-tpls.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'angular-google-chart', $registry->getBowerComponentUrl() . "angular-google-chart/ng-google-chart.js", array('angular'), $registry->getPluginVersion() );

				wp_enqueue_script( 'algolia-search-lib', $registry->getScriptsUrl() . "libs/algoliasearch.min.js", array('angular'), $registry->getPluginVersion() );
				wp_enqueue_script( 'mavenAlgoliaApp', $registry->getFrontScriptsUrl() . "app.js", array('algolia-search-lib'), $registry->getPluginVersion() );
				wp_enqueue_script( 'ma-config', $registry->getFrontScriptsUrl() . "services/ma-config.js", array('mavenAlgoliaApp'), $registry->getPluginVersion() );
				wp_enqueue_script( 'algolia-helper', $registry->getFrontScriptsUrl() . "services/algolia-helper.js", array('mavenAlgoliaApp'), $registry->getPluginVersion() );
				wp_enqueue_script( 'algolia-client', $registry->getFrontScriptsUrl() . "services/algolia-client.js", array('mavenAlgoliaApp'), $registry->getPluginVersion() );

//				wp_enqueue_style( 'bootstrap', $registry->getBowerComponentUrl() . "bootstrap/dist/css/bootstrap.css", null, $registry->getPluginVersion() );
//				wp_enqueue_style( 'bootstrap-theme', $registry->getBowerComponentUrl() . "bootstrap/dist/css/bootstrap-theme.css", null, $registry->getPluginVersion() );

//				wp_enqueue_style( 'main', $registry->getStylesUrl() . "main.css", array( 'bootstrap', 'bootstrap-theme' ), $registry->getPluginVersion() );
			} else {
				wp_enqueue_script( 'mavenAlgoliaApp', $registry->getScriptsUrl() . "main.min.js", 'angular', $registry->getPluginVersion() );
				//wp_enqueue_style( 'mainCss', $registry->getStylesUrl() . "main.min.css", array(), $registry->getPluginVersion() );
			}

			wp_localize_script( 'mavenAlgoliaApp', 'MASearchConfig', array(
				'adminUrl' => admin_url(),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'frontViewsUrl' => $registry->getFrontViewsUrl(),
				'algoliaAppId' => 'W1RXWVXKIB',
				'algoliaApiKey' => '19a56a603b66c79850a2a3ac6faf5ce6',
				'debug' => ( defined('MAVEN_DEBUG') && MAVEN_DEBUG )
			) );
		}
	}

}

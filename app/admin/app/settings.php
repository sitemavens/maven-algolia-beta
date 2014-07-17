<?php

namespace GFSeoMarketingAddOn\Admin\App;

// Exit if accessed directly 
if ( ! defined( 'ABSPATH' ) )
	exit;

class Settings {

	public function getSettings() {

		$registry = \GFSeoMarketingAddOn\Core\Settings\GfRegistry::instance();
		
		$options = $registry->getPublicOptions();
		
		
		
		\GFSeoMarketingAddOn\Core\Output::sendCollection( $options );
	}
	
	
	public function saveSettings(){
		
		$request = \GFSeoMarketingAddOn\Core\Request::current();
		$registry = \GFSeoMarketingAddOn\Core\Settings\GfRegistry::instance();
		$options = $registry->getPublicOptions();
		
		// Read the settings from request
		$requestSettings = $request->getProperty('settings');
		
		foreach( $options as $option ){
			foreach($requestSettings as $setting){
				if ( $setting['id'] === $option->getId() ){
					$option->setValue( $setting['value']);
					continue;
				}
			}
		}
		
		// Update the settings
		$registry->saveOptions($options);
		
		\GFSeoMarketingAddOn\Core\Output::sendCollection( $options );
		
	}
 
	
	public function updateReferrals(){
		
		$request = \GFSeoMarketingAddOn\Core\Request::current();
		
		$entryManager = new \GFSeoMarketingAddOn\Core\EntryManager();
		$entryManager->updateReferrals();
		
		\GFSeoMarketingAddOn\Core\Output::send( true );
		
	}
 

}

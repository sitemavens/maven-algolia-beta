<?php

namespace MavenEvents\Admin;

abstract class EventsAdminController extends \Maven\Core\Ui\AdminController{
	
	public function __construct(){
		
		parent::__construct( \MavenEvents\Settings\EventsRegistry::instance() );
		
		// We set the message manager and the key generator
		//$this->setMessageManager( \Maven\Core\Message\MessageManager::getInstance( new \Maven\Core\Message\UserMessageKeyGenerator() ) );
	}
	
}
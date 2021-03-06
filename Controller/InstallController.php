<?php
App::uses('Install', 'Model');

/**
 * Auto-Installer
 * 2010-01-19 ms
 */
class InstallController extends SetupAppController {

	public $helpers = array('Html', 'Form', 'Session', 'Tools.Common', 'Tools.Format');

	public $components = array('Session', 'Tools.Common');

	public $uses = array('Install');


	public function beforeFilter() {
		parent::beforeFilter();
		
		if (isset($this->Auth)) {
			$this->Auth->allow('*');
		}
		
		if (!Configure::read('debug')) {
			throw new MethodNotAllowedException('Debug Mode needs to be enabled for this');
		}
	}


	public function index() {

	}

	/**
	 * sql tables
	 */
	public function step1() {
		if ($this->Common->isPosted()) {
			$this->Install = @ClassRegistry::init('Install');
			if ($this->Install->createDatabaseFile($this->request->data)) {
				$this->Common->flashMessage('database.php created', 'success');
				$this->Common->postRedirect(array('action'=>'step2'));
			}
			
		} else {
			$this->request->data['Install'] = array(
				'datasource' => 'Database/Mysql',
				'host' => 'localhost',
				'login' => 'root',
				'database' => 'cake',
				'prefix' => 'app_',
				'encoding' => 'utf8',
				'enhanced_database_class' => true,
				'name' => 'default',
				'environment' => HTTP_HOST,
				'path' => array(),
			);
		}
	}

	/**
	 * ?
	 */
	public function step2() {

	}
	
}
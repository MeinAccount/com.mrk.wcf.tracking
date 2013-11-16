<?php
namespace wcf\acp\form;
use wcf\data\tracking\provider\TrackingProvider;
use wcf\data\tracking\provider\TrackingProviderAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the tracking provider edit form.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProviderEditForm extends TrackingProviderAddForm {
	/**
	 * tracking provider id
	 * @var	integer
	 */
	public $trackingProviderID = 0;
	
	/**
	 * tracking provider object
	 * @var	\wcf\data\tracking\provider\TrackingProvider
	 */
	public $trackingProvider = null;
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		AbstractForm::readParameters();
		
		if (isset($_REQUEST['id'])) $this->trackingProviderID = intval($_REQUEST['id']);
		$this->trackingProvider = new TrackingProvider($this->trackingProviderID);
		if (!$this->trackingProvider->trackingProviderID) {
			throw new IllegalLinkException();
		}
		
		// create provider instance
		$this->className = $this->trackingProvider->className;
		$className = $this->trackingProvider->className;
		$this->provider = new $className();
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// update tracking provider
		$data = array(
			'providerName' => $this->providerName,
			'trackingURL' => $this->trackingURL,
			'trackingID' => $this->trackingID
		);
		
		$this->objectAction = new TrackingProviderAction(array($this->trackingProviderID), 'update', array('data' => $data));
		$this->objectAction->executeAction();
		$this->saved();
		
		// show success
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (empty($_POST)) {
			$this->providerName = $this->trackingProvider->providerName;
			$this->trackingURL = $this->trackingProvider->trackingURL;
			$this->trackingID = $this->trackingProvider->trackingID;
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'trackingProviderID' => $this->trackingProviderID,
			'trackingProvider' => $this->trackingProvider,
			'action' => 'edit'
		));
	}
}

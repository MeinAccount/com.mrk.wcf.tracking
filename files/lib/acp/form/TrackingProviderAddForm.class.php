<?php
namespace wcf\acp\form;
use wcf\data\tracking\provider\TrackingProviderAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\tracking\TrackingHandler;
use wcf\system\WCF;
use wcf\util\FileUtil;
use wcf\util\StringUtil;

/**
 * Shows the tracking provider add form.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProviderAddForm extends AbstractForm {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.user.tracking';

	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.user.canManageTrackingProvider');

	/**
	 * tracking provider name
	 * @var	string
	 */
	public $providerName = '';

	/**
	 * tracking provider class name
	 * @var	string
	 */
	public $className = '';

	/**
	 * tracking provider
	 * @var	wcf\system\tracking\provider\ITrackingProvider
	 */
	public $provider = null;

	/**
	 * tracking url
	 * @var	string
	 */
	public $trackingURL = null;

	/**
	 * tracking id
	 * @var	integer
	 */
	public $trackingID = null;

	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (empty($_REQUEST['className'])) {
			throw new IllegalLinkException();
		}
		
		// check class name
		$this->className = StringUtil::trim($_REQUEST['className']);
		if (!TrackingHandler::getInstance()->isValidProvider($this->className)) {
			throw new IllegalLinkException();
		}
		
		// create provider instance
		$className = $this->className;
		$this->provider = new $className();
	}

	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		if (!empty($_POST['providerName'])) $this->providerName = StringUtil::trim($_POST['providerName']);
		if (!empty($_POST['trackingURL'])) $this->trackingURL = StringUtil::trim($_POST['trackingURL']);
		if (!empty($_POST['trackingID'])) $this->trackingID = intval($_POST['trackingID']);

		if (!empty($this->trackingURL)) {
			$this->trackingURL = FileUtil::addTrailingSlash($this->trackingURL);
		}
	}

	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();

		// validate provider name
		if (empty($this->providerName)) {
			throw new UserInputException('providerName');
		}

		// validate tracking url
		if ($this->provider->requiresURL() && empty($this->trackingURL)) {
			throw new UserInputException('trackingURL');
		}

		// validate tracking id
		if ($this->provider->requiresID() && empty($this->trackingID)) {
			throw new UserInputException('trackingID');
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();

		// save tracking provider
		$data = array(
			'className' => $this->className,
			'providerName' => $this->providerName,
			'trackingURL' => $this->trackingURL,
			'trackingID' => $this->trackingID
		);

		$this->objectAction = new TrackingProviderAction(array(), 'create', array('data' => $data));
		$this->objectAction->executeAction();
		$this->saved();

		// reset values
		$this->providerName = '';
		$this->trackingURL = $this->trackingID = null;

		// show success.
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'className' => $this->className,
			'provider' => $this->provider,
			'providerName' => $this->providerName,
			'trackingURL' => $this->trackingURL,
			'trackingID' => $this->trackingID,
			'action' => 'add'
		));
	}
}

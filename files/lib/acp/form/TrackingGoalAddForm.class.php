<?php
namespace wcf\acp\form;
use wcf\data\tracking\goal\TrackingGoal;
use wcf\data\tracking\goal\TrackingGoalAction;
use wcf\data\tracking\goal\TrackingGoalEditor;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Shows the tracking goal add form.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalAddForm extends AbstractForm {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.user.tracking.goal.add';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.user.canManageTrackingGoal');
	
	/**
	 * tracking goal name
	 * @var	string
	 */
	public $goalName = '';

	/**
	 * tracking goal description
	 * @var	string
	 */
	public $description = '';
	
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
		
		I18nHandler::getInstance()->register('description');
	}
	
	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		I18nHandler::getInstance()->readValues();
		if (!empty($_POST['goalName'])) $this->goalName = StringUtil::trim($_POST['goalName']);
		if (!empty($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
		if (!empty($_POST['trackingID'])) $this->trackingID = intval($_POST['trackingID']);
	}
	
	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		$this->validateGoalName();
		
		// validate description
		if (!I18nHandler::getInstance()->validateValue('description')) {
			if (I18nHandler::getInstance()->isPlainValue('description')) {
				throw new UserInputException('description');
			} else {
				throw new UserInputException('description', 'multilingual');
			}
		}
		
		// validate tracking id
		if (!$this->trackingID) {
			throw new UserInputException('trackingID');
		}
	}

	/**
	 * Validates the goal name
	 */
	protected function validateGoalName() {
		if (empty($this->goalName)) {
			throw new UserInputException('goalName');
		}
		
		// check for duplicate
		$sql = "SELECT	COUNT(trackingGoalID) AS count
			FROM	".TrackingGoal::getDatabaseTableName()."
			WHERE	goalName = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->goalName));
		$row = $statement->fetchArray();
		if ($row['count']) {
			throw new UserInputException('goalName', 'notUnique');
		}
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		// save tracking goal
		$data = array(
			'goalName' => $this->goalName,
			'description' => $this->description,
			'packageID' => 1,
			'isDisabled' => 0,
			'trackingID' => $this->trackingID
		);
		
		$this->objectAction = new TrackingGoalAction(array(), 'create', array('data' => $data));
		$this->objectAction->executeAction();
		$this->saved();
		
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$returnValues = $this->objectAction->getReturnValues();
			$trackingGoalID = $returnValues['returnValues']->trackingGoalID;
			I18nHandler::getInstance()->save('description', 'wcf.acp.tracking.goal.description'.$trackingGoalID, 'wcf.acp.tracking', 1);
			
			// update tracking goal description
			$trackingGoalEditor = new TrackingGoalEditor($returnValues['returnValues']);
			$trackingGoalEditor->update(array(
				'description' => 'wcf.acp.tracking.goal.description'.$trackingGoalID
			));
		}
		
		// reset values
		$this->goalName = $this->description = '';
		I18nHandler::getInstance()->reset();
		
		// show success.
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign(array(
			'goalName' => $this->goalName,
			'description' => $this->description,
			'trackingID' => $this->trackingID,
			'action' => 'add'
		));
	}
}

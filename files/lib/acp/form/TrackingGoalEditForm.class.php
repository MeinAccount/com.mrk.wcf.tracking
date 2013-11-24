<?php
namespace wcf\acp\form;
use wcf\data\tracking\goal\TrackingGoal;
use wcf\data\tracking\goal\TrackingGoalAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;

/**
 * Shows the tracking goal edit form.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalEditForm extends TrackingGoalAddForm {
	/**
	 * tracking goal id
	 * @var	integer
	 */
	public $trackingGoalID = 0;
	
	/**
	 * tracking goal object
	 * @var	\wcf\data\tracking\goal\TrackingGoal
	 */
	public $trackingGoal = null;
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->trackingGoalID = intval($_REQUEST['id']);
		$this->trackingGoal = new TrackingGoal($this->trackingGoalID);
		if (!$this->trackingGoal->trackingGoalID) {
			throw new IllegalLinkException();
		}
	}

	/**
	 * @see	\wcf\acp\form\TrackingGoalAddForm::validateGoalName()
	 */
	protected function validateGoalName() {
		if ($this->goalName != $this->trackingGoal->goalName) {
			parent::validateGoalName();
		}
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		$this->description = 'wcf.acp.tracking.goal.description'.$this->trackingGoal->trackingGoalID;
		if (I18nHandler::getInstance()->isPlainValue('description')) {
			I18nHandler::getInstance()->remove($this->description);
			$this->description = I18nHandler::getInstance()->getValue('description');
		} else {
			I18nHandler::getInstance()->save('description', $this->description, 'wcf.acp.tracking', $this->trackingGoal->trackingGoalID);
		}
		
		// update tracking goal
		$data = array(
			'goalName' => $this->goalName,
			'description' => $this->description,
			'trackingID' => $this->trackingID
		);
		
		$this->objectAction = new TrackingGoalAction(array($this->trackingGoalID), 'update', array('data' => $data));
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
			I18nHandler::getInstance()->setOptions('description', $this->trackingGoal->trackingGoalID, $this->trackingGoal->description, 'wcf.acp.tracking.goal.description\d+');
			
			$this->goalName = $this->trackingGoal->goalName;
			$this->description = $this->trackingGoal->description;
			$this->trackingID = $this->trackingGoal->trackingID;
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables(!empty($_POST));
		
		WCF::getTPL()->assign(array(
			'trackingGoalID' => $this->trackingGoalID,
			'trackingGoal' => $this->trackingGoal,
			'action' => 'edit'
		));
	}
}

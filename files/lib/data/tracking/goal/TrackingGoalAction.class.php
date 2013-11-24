<?php
namespace wcf\data\tracking\goal;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\data\option\OptionAction;
use wcf\data\option\OptionEditor;
use wcf\system\cache\builder\OptionCacheBuilder;
use wcf\system\cache\builder\TrackingProviderCacheBuilder;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;

/**
 * Executes tracking goal-related actions.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalAction extends AbstractDatabaseObjectAction implements IToggleAction {
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\tracking\goal\TrackingGoalEditor';
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsCreate
	 */
	protected $permissionsCreate = array('admin.user.canManageTrackingGoal');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.user.canManageTrackingGoal');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.user.canManageTrackingGoal');
	
	/**
	 * @see	\wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		$this->objectIDs = array();
		foreach ($this->objects as $trackingGoal) {
			if (!$trackingGoal->isDisabled || $trackingGoal->trackingID) { // only allow enabling configured goals
				$trackingGoal->update(array('isDisabled' => $trackingGoal->isDisabled ? 0 : 1));
				$this->objectIDs[] = intval($trackingGoal->trackingGoalID);
			}
		}
	}
	
	/**
	 * @see	\wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		parent::validateUpdate();
	}

	/**
	 * Sets the tracking provider to use for goal tracking
	 */
	public function setTrackingProvider() {
		$trackingProvider = TrackingProviderCacheBuilder::getInstance()->getData(array(), array_pop($this->objectIDs));
		if (!$trackingProvider || !$trackingProvider->getProvider()->supportsGoalTracking()) {
			throw new UserInputException('objectIDs');
		}
		
		$options = OptionCacheBuilder::getInstance()->getData(array(), 'options');
		$objectAction = new OptionAction(array($options['tracking_goal_provider']), 'update', array('data' => array('optionValue' => $trackingProvider->trackingProviderID)));
		$objectAction->executeAction();
		OptionEditor::resetCache(); // @todo this is a wcf bug
	}

	/**
	 * Validates the "setTrackingProvider" action.
	 */
	public function validateSetTrackingProvider() {
		if (empty($this->objectIDs)) {
			throw new UserInputException('objectIDs');
		}
		
		WCF::getSession()->checkPermissions($this->permissionsCreate);
	}
}

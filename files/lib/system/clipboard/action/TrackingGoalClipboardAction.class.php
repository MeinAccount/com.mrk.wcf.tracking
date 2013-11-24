<?php
namespace wcf\system\clipboard\action;
use wcf\data\clipboard\action\ClipboardAction;
use wcf\system\WCF;

/**
 * Prepares clipboard editor items for tracking goals.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalClipboardAction extends AbstractClipboardAction {
	/**
	 * @see	\wcf\system\clipboard\action\AbstractClipboardAction::$actionClassActions
	 */
	protected $actionClassActions = array('delete');
	
	/**
	 * @see	\wcf\system\clipboard\action\AbstractClipboardAction::$supportedActions
	 */
	protected $supportedActions = array('enable', 'disable', 'delete');
	
	/**
	 * @see	\wcf\system\clipboard\action\IClipboardAction::execute()
	 */
	public function execute(array $objects, ClipboardAction $action) {
		$item = parent::execute($objects, $action);

		// handle actions
		if ($item !== null && $action->actionName == 'delete') {
			$item->addInternalData('confirmMessage', WCF::getLanguage()->getDynamicVariable('wcf.clipboard.item.com.mrk.wcf.tracking.goal.delete.confirmMessage', array('count' => $item->getCount())));
		}

		return $item;
	}
	
	/**
	 * @see	\wcf\system\clipboard\action\IClipboardAction::getClassName()
	 */
	public function getClassName() {
		return 'wcf\data\tracking\goal\TrackingGoalAction';
	}
	
	/**
	 * @see	\wcf\system\clipboard\action\IClipboardAction::getTypeName()
	 */
	public function getTypeName() {
		return 'com.mrk.wcf.tracking.goal';
	}
	
	/**
	 * Returns the ids of the tracking goals which can be deleted.
	 *
	 * @return	array<integer>
	 */
	protected function validateDelete() {
		// check permissions
		if (!WCF::getSession()->getPermission('admin.user.canManageTrackingGoal')) {
			return array();
		}

		return array_keys($this->objects);
	}
	
	/**
	 * Returns the ids of the tracking goals which can be enabled.
	 *
	 * @return	array<integer>
	 */
	protected function validateEnable() {
		// check permissions
		if (!WCF::getSession()->getPermission('admin.user.canManageTrackingGoal')) {
			return array();
		}
		
		$trackingGoalIDs = array();
		foreach ($this->objects as $trackingGoal) {
			if ($trackingGoal->isDisabled && $trackingGoal->trackingID) {
				$trackingGoalIDs[] = $trackingGoal->trackingGoalID;
			}
		}
		
		return $trackingGoalIDs;
	}
	
	/**
	 * Returns the ids of the tracking goals which can be disabled.
	 *
	 * @return	array<integer>
	 */
	protected function validateDisable() {
		// check permissions
		if (!WCF::getSession()->getPermission('admin.user.canManageTrackingGoal')) {
			return array();
		}
		
		$trackingGoalIDs = array();
		foreach ($this->objects as $trackingGoal) {
			if (!$trackingGoal->isDisabled) {
				$trackingGoalIDs[] = $trackingGoal->trackingGoalID;
			}
		}
		
		return $trackingGoalIDs;
	}
}

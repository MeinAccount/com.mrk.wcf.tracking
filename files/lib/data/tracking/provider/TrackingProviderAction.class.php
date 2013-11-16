<?php
namespace wcf\data\tracking\provider;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\system\tracking\TrackingHandler;
use wcf\system\WCF;
use wcf\util\ClassUtil;

/**
 * Executes tracking provider-related actions.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProviderAction extends AbstractDatabaseObjectAction implements IToggleAction {
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\tracking\provider\TrackingProviderEditor';
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsCreate
	 */
	protected $permissionsCreate = array('admin.user.canManageTrackingProvider');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.user.canManageTrackingProvider');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.user.canManageTrackingProvider');
	
	/**
	 * @see	\wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		foreach ($this->objects as $trackingProvider) {
			$trackingProvider->update(array(
				'isDisabled' => $trackingProvider->isDisabled ? 0 : 1
			));
		}
	}
	
	/**
	 * @see	\wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		parent::validateUpdate();
	}
	
	/**
	 * Checks if a class name is a valid tracking provider 
	 */
	public function checkClassName() {
		if (!class_exists($this->parameters['className'])) {
			return 'notFound';
		}
		
		if (!TrackingHandler::getInstance()->isValidProvider($this->parameters['className'])) {
			return 'invalid';
		}
		
		return 'valid';
	}
	
	/**
	 * Validates the "checkClassName" action.
	 */
	public function validateCheckClassName() {
		$this->readString('className');
		WCF::getSession()->checkPermissions($this->permissionsCreate);
	}
}

<?php
namespace wcf\acp\page;
use wcf\page\SortablePage;
use wcf\system\cache\builder\TrackingProviderCacheBuilder;
use wcf\system\clipboard\ClipboardHandler;
use wcf\system\WCF;

/**
 * Shows information about tracking providers.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalListPage extends SortablePage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.user.tracking.goal.list';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.user.canManageTrackingGoal');
	
	/**
	 * @see	\wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'goalName';
	
	/**
	 * @see	\wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = array('trackingGoalID', 'goalName', 'description', 'packageID', 'trackingProviderID', 'trackingID');
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\tracking\goal\TrackingGoalList';
	
	/**
	 * list of tracking providers
	 * @var	array<\wcf\data\tracking\provider\TrackingProvider>
	 */
	public $trackingProviders = array();
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		foreach (TrackingProviderCacheBuilder::getInstance()->getData() as $trackingProvider) {
			if ($trackingProvider->getProvider()->supportsGoalTracking()) {
				$this->trackingProviders[$trackingProvider->trackingProviderID] = $trackingProvider;
			}
		}
		
		parent::readData();
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'hasMarkedItems' => ClipboardHandler::getInstance()->hasMarkedItems(ClipboardHandler::getInstance()->getObjectTypeID('com.woltlab.wcf.user')),
			'trackingProviders' => $this->trackingProviders,
			'trackingProviderInvalid' => !in_array(TRACKING_GOAL_PROVIDER, array_keys($this->trackingProviders))
		));
	}
}

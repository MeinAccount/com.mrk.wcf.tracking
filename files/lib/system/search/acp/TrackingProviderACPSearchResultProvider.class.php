<?php
namespace wcf\system\search\acp;
use wcf\data\tracking\provider\TrackingProviderList;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * ACP search result provider implementation for tracking providers.
 * 
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProviderACPSearchResultProvider implements IACPSearchResultProvider {
	/**
	 * @see	\wcf\system\search\acp\IACPSearchResultProvider::search()
	 */
	public function search($query) {
		if (!WCF::getSession()->getPermission('admin.user.canManageTrackingProvider')) {
			return array();
		}
		
		// fetch tracking providers
		$trackingProviderList = new TrackingProviderList();
		$trackingProviderList->getConditionBuilder()->add('providerName LIKE ?', array($query.'%'));
		$trackingProviderList->readObjects();
		
		// create result set
		$results = array();
		foreach ($trackingProviderList->getObjects() as $trackingProvider) {
			$results[] = new ACPSearchResult($trackingProvider->getTitle(), LinkHandler::getInstance()->getLink('TrackingProviderEdit', array('object' => $trackingProvider)));
		}
		
		return $results;
	}
}

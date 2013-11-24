<?php
namespace wcf\system\cache\builder;
use wcf\data\tracking\provider\TrackingProviderList;

/**
 * Caches all tracking providers
 *
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class TrackingProviderCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see	\wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild(array $parameters) {
		$trackingProviderList = new TrackingProviderList();
		$trackingProviderList->readObjects();
		return $trackingProviderList->getObjects();
	}
}

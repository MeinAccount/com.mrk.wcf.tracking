<?php
namespace wcf\system\cache\builder;
use wcf\data\tracking\provider\TrackingProviderList;

/**
 * Caches the tracking code. 
 * 
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class TrackingCodeCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see \wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild(array $parameters) {
		$trackingProviders = new TrackingProviderList();
		$trackingProviders->getConditionBuilder()->add('isDisabled = ?', array(0));
		$trackingProviders->readObjects();
		
		$trackingCode = '';
		foreach ($trackingProviders->getObjects() as $trackingProvider) {
			$className = $trackingProvider->className;
			$provider = new $className();
			$trackingCode .= $provider->getTrackingCode($trackingProvider);
		}
		
		return array('code' => $trackingCode);
	}
}

<?php
namespace wcf\system\tracking;
use wcf\system\cache\builder\TrackingCodeCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\ClassUtil;

/**
 * Handles tracking
 * 
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingHandler extends SingletonFactory {
	/**
	 * Gets the tracking code
	 * 
	 * @return string
	 */
	public function getTrackingCode() {
		if (WCF::getSession()->getPermission('admin.user.isNotTracked')) {
			return '';
		}
		
		return TrackingCodeCacheBuilder::getInstance()->getData(array(), 'code');
	}
	
	/**
	 * Checks if the given class name is a valid tracking provider
	 * 
	 * @param string $className
	 * @return boolean
	 */
	public function isValidProvider($className) {
		if (!class_exists($className)) {
			return false;
		}
		
		return ClassUtil::isInstanceOf($className, 'wcf\system\tracking\provider\ITrackingProvider');
	}
}

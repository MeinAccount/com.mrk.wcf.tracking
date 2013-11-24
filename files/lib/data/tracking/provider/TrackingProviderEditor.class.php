<?php
namespace wcf\data\tracking\provider;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\cache\builder\TrackingCodeCacheBuilder;
use wcf\system\cache\builder\TrackingProviderCacheBuilder;

/**
 * Provides functions to edit tracking providers.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProviderEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\tracking\provider\TrackingProvider';
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		TrackingProviderCacheBuilder::getInstance()->reset();
		TrackingCodeCacheBuilder::getInstance()->reset();
	}
}

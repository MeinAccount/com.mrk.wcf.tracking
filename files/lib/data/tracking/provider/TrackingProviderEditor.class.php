<?php
namespace wcf\data\tracking\provider;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\cache\builder\TrackingCodeCacheBuilder;

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
	 * Resets the cache of this object type.
	 */
	public static function resetCache() {
		TrackingCodeCacheBuilder::getInstance()->reset();
	}
}

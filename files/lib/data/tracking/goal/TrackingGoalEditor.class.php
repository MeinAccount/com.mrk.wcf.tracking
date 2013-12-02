<?php
namespace wcf\data\tracking\goal;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\data\language\category\LanguageCategory;
use wcf\data\language\item\LanguageItem;
use wcf\data\language\LanguageList;
use wcf\system\cache\builder\TrackingGoalCacheBuilder;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

/**
 * Provides functions to edit tracking goals.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\tracking\goal\TrackingGoal';

	/**
	 * @see	\wcf\data\IEditableObject::create()
	 */
	public static function create(array $parameters = array()) {
		$descriptions = array();
		if (isset($parameters['description']) && is_array($parameters['description'])) {
			if (count($parameters['description']) > 1) {
				$descriptions = $parameters['description'];
				$parameters['description'] = '';
			}
			else {
				$parameters['description'] = reset($parameters['description']);
			}
		}

		$trackingGoal = parent::create($parameters);

		// save tracking goal description
		if (!empty($descriptions)) {
			// set default value
			if (isset($descriptions[''])) {
				$defaultValue = $descriptions[''];
			}
			else if (isset($descriptions['en'])) {
				// fallback to English
				$defaultValue = $descriptions['en'];
			}
			else if (isset($descriptions[WCF::getLanguage()->getFixedLanguageCode()])) {
				// fallback to the language of the current user
				$defaultValue = $descriptions[WCF::getLanguage()->getFixedLanguageCode()];
			}
			else {
				// fallback to first description
				$defaultValue = reset($descriptions);
			}

			// fetch data directly from database during framework installation
			if (!PACKAGE_ID) {
				$sql = "SELECT	*
					FROM	".LanguageCategory::getDatabaseTableName()."
					WHERE	languageCategory = ?";
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array('wcf.acp.tracking'));
				$languageCategory = $statement->fetchObject('wcf\data\language\category\LanguageCategory');

				$languages = new LanguageList();
				$languages->readObjects();
			}
			else {
				$languages = LanguageFactory::getInstance()->getLanguages();
				$languageCategory = LanguageFactory::getInstance()->getCategory('wcf.acp.tracking');
			}

			$sql = "INSERT INTO	".LanguageItem::getDatabaseTableName()."
						(languageID, languageItem, languageItemValue, languageCategoryID, packageID)
				VALUES		(?, ?, ?, ?, ?)";
			$statement = WCF::getDB()->prepareStatement($sql);

			foreach ($languages as $language) {
				$value = $defaultValue;
				if (isset($descriptions[$language->languageCode])) {
					$value = $descriptions[$language->languageCode];
				}

				$statement->execute(array(
					$language->languageID,
					'wcf.acp.tracking.goal.description'.$trackingGoal->trackingGoalID,
					$value,
					$languageCategory->languageCategoryID,
					$trackingGoal->packageID
				));
			}

			// update tracking goal
			$trackingGoalEditor = new TrackingGoalEditor($trackingGoal);
			$trackingGoalEditor->update(array(
				'description' => 'wcf.acp.tracking.goal.description'.$trackingGoal->trackingGoalID
			));
		}

		return $trackingGoal;
	}
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		TrackingGoalCacheBuilder::getInstance()->reset();
	}
}

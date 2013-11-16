<?php
namespace wcf\page;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * Represents the opt out page for tracking.
 * 
 * @author      Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @package     com.mrk.wcf.tracking
 */
class TrackingPage extends AbstractPage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.tracking.opt_out';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_TRACKING');

	/**
	 * @see wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		// breadcrumbs
		WCF::getBreadcrumbs()->add(new Breadcrumb(WCF::getLanguage()->get('wcf.tracking.opt_out'), LinkHandler::getInstance()->getLink('Tracking')));
	}
}

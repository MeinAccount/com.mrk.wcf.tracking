/**
 * Initialize tracking namespace
 */
WCF.Tracking = { };

/**
 * Basic implementation for classes with an AJAX-based proxy
 * @todo pull request to WCF?
 */
WCF.Tracking.ProxyClass = Class.extend({
	/**
	 * @var	WCF.Action.Proxy
	 */
	_proxy: undefined,
	
	/**
	 * Creates the ajax proxy
	 */
	_createProxy: function() {
		if (this._proxy === undefined) {
			this._proxy = new WCF.Action.Proxy({
				success: $.proxy(this._success, this),
				failure: $.proxy(this._failure, this)
			});
		}
	},

	/**
	 * Sends an AJAX request
	 * @param	object	data
	 */
	_sendRequest: function(data) {
		this._createProxy();
		
		this._proxy.setOption('data', data);
		this._proxy.sendRequest();
	},

	/**
	 * Handles successful AJAX requests
	 *
	 * @param	object		data
	 * @param	string		textStatus
	 * @param	object		jqXHR
	 */
	_success: function(data, jqXHR, textStatus) { },
	
	/**
	 * Handles AJAX errors
	 * 
	 * @param	object	data
	 * @param	object	jqXHR
	 * @param	string	textStatus
	 * @param	string	errorThrown
	 */
	_failure: function(data, jqXHR, textStatus, errorThrown) { }
});

/**
 * Namespace for the GoalListPage
 */
WCF.Tracking.GoalList = { };

/**
 * Handler for TrackingGoalListPage
 * Allows selection of a tracking provider for goal tracking
 */
WCF.Tracking.GoalList.SelectProvider = WCF.Tracking.ProxyClass.extend({
	/**
	 * Initializes the goal tracking provider selection form.
	 */
	init: function() {
		$('#goalTrackingProvider').submit($.proxy(this._submit, this));
	},

	/**
	 * Submits the form
	 */
	_submit: function(event) {
		event.preventDefault();
		this._sendRequest({
			className: 'wcf\\data\\tracking\\goal\\TrackingGoalAction',
			actionName: 'setTrackingProvider',
			objectIDs: [ $('#trackingProvider').val() ]
		});
	},

	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_success: function() {
		$('#goalTrackingProvider small').removeClass('innerError');
		
		new WCF.System.Notification(WCF.Language.get('wcf.global.success.edit')).show();
	},
	
	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_failure: function() {
		$('#goalTrackingProvider small').addClass('innerError');
	}
});

/**
 * Implementation for AJAXProxy-based toggle actions on tracking goals
 */
WCF.Tracking.GoalList.Toggle = WCF.Action.Toggle.extend({
	/**
	 * @see	WCF.Action.Toggle._click()
	 */
	_click: function(event) {
		if ($(event.currentTarget).data('valid')) {
			this._super(event);
		}
	}
});

/**
 * Handler for the TrackingProviderStartPage
 */
WCF.Tracking.ProviderStart = WCF.Tracking.ProxyClass.extend({
	/**
	 * Initializes the TrackingProviderStartPage
	 */
	init: function() {
		$('#classNameForm').submit($.proxy(this._submit, this));
	},

	/**
	 * Submits the form
	 */
	_submit: function(event) {
		event.preventDefault();
		this._sendRequest({
			className: 'wcf\\data\\tracking\\provider\\TrackingProviderAction',
			actionName: 'checkClassName',
			parameters: {
				className: $('#className').val()
			}
		});
	},

	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_success: function(data) {
		if (data.returnValues == 'valid') {
			$('#classNameForm').off().submit();
		} else {
			$('#classNameForm dl').addClass('formError');
			$('#classNameForm small').removeClass('invisible').text(WCF.Language.get('wcf.acp.tracking.provider.className.error.'+data.returnValues));
		}
	}
});

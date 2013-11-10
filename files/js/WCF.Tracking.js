WCF.Tracking = { };

WCF.Tracking.StartHandler = Class.extend({
	init: function() {
		$('#classNameForm').submit($.proxy(this._submit, this));
	},

	/**
	 * Creates the ajax proxy
	 * @private
	 */
	_createProxy: function() {
		if (this._proxy === undefined) {
			this._proxy = new WCF.Action.Proxy({
				success: $.proxy(this._success, this)
			});
		}
	},

	/**
	 * Submits the form
	 * @private
	 */
	_submit: function(event) {
		this._createProxy();
		event.preventDefault();
		
		this._proxy.setOption('data', {
			className: 'wcf\\data\\tracking\\provider\\TrackingProviderAction',
			actionName: 'checkClassName',
			parameters: {
				className: $('#className').val()
			}
		});
		this._proxy.sendRequest();
	},

	/**
	 * Handels the response
	 * @param data
	 * @private
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

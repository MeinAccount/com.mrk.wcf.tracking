{include file='header' pageTitle='wcf.acp.tracking.provider.'|concat:$action}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.tracking.provider.{$action}{/lang}</h1>
</header>

{include file='formError'}
{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>
{/if}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='TrackingProviderList'}{/link}" class="button"><span class="icon icon16 icon-list"></span> <span>{lang}wcf.acp.tracking.provider.list{/lang}</span></a></li>
			
			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='TrackingProviderAdd'}{/link}{else}{link controller='TrackingProviderEdit' object=$trackingProvider}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>

			<dl{if $errorField == 'providerName'} class="formError"{/if}>
				<dt><label for="providerName">{lang}wcf.acp.tracking.provider.providerName{/lang}</label></dt>
				<dd>
					<input type="text" id="providerName" name="providerName" value="{$providerName}" required="required" autofocus="autofocus" class="long" />
					{if $errorField == 'providerName'}
						<small class="innerError">{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{else}{lang}wcf.acp.tracking.provider.providerName.error.{@$errorType}{/lang}{/if}</small>
					{/if}
				</dd>
			</dl>
			
			<dl>
				<dt><label for="className">{lang}wcf.acp.tracking.provider.className{/lang}</label></dt>
				<dd>
					<input type="text" id="className" name="className" value="{$className}" readonly="readonly" class="long" />
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>

		{if $provider->requiresURL() || $provider->requiresID()}
			<fieldset>
				<legend>{lang}wcf.acp.tracking.provider{/lang}</legend>
				
				{if $provider->requiresURL()}
					<dl{if $errorField == 'trackingURL'} class="formError"{/if}>
						<dt><label for="trackingURL">{lang}wcf.acp.tracking.provider.trackingURL{/lang}</label></dt>
						<dd>
							<input type="text" id="trackingURL" name="trackingURL" value="{$trackingURL}" required="required" class="long" />
							{if $errorField == 'trackingURL'}<small class="innerError">{lang}wcf.global.form.error.empty{/lang}</small>{/if}
							<small>{lang}wcf.acp.tracking.provider.trackingURL.description{/lang}</small>
						</dd>
					</dl>
				{/if}
				{if $provider->requiresID()}
					<dl{if $errorField == 'trackingID'} class="formError"{/if}>
						<dt><label for="trackingID">{lang}wcf.acp.tracking.provider.trackingID{/lang}</label></dt>
						<dd>
							<input type="text" id="trackingID" name="trackingID" value="{$trackingID}" required="required" class="long" />
							{if $errorField == 'trackingID'}<small class="innerError">{lang}wcf.global.form.error.empty{/lang}</small>{/if}
							<small>{lang}wcf.acp.tracking.provider.trackingID.description{/lang}</small>
						</dd>
					</dl>
				{/if}
			</fieldset>
		{/if}

		{event name='fieldsets'}
	</div>

	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}

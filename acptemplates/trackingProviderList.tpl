{include file='header' pageTitle='wcf.acp.tracking.provider.list'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.tracking.provider.list{/lang}</h1>
</header>

<script data-relocate="true" src="{@$__wcf->getPath('wcf')}js/WCF.Tracking{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
<script data-relocate="true">
	//<![CDATA[
	$(function() {
		var actionObjects = { };
		actionObjects['delete'] = new WCF.Action.Delete('wcf\\data\\tracking\\provider\\TrackingProviderAction', '.jsTrackingProviderRow');
		WCF.Clipboard.init('wcf\\acp\\page\\TrackingProviderListPage', {@$hasMarkedItems}, { 'com.mrk.wcf.tracking.provider': actionObjects });
		new WCF.Tracking.ClipboardToggle('wcf\\data\\tracking\\provider\\TrackingProviderAction', '.jsTrackingProviderRow', '.jsToggleButton', 'com.mrk.wcf.tracking.provider');
		
		var options = { };
		{if $pages > 1}
			options.refreshPage = true;
			{if $pages == $pageNo}options.updatePageNumber = -1;{/if}
		{else}
			options.emptyMessage = '{lang}wcf.global.noItems{/lang}';
		{/if}
		new WCF.Table.EmptyTableHandler($('#trackingProviderTableContainer'), 'jsTrackingProviderRow', options);
	});
	//]]>
</script>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="TrackingProviderList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	<nav>
		<ul>
			<li><a href="{link controller='TrackingProviderStart'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.tracking.provider.add{/lang}</span></a></li>
			
			{event name='contentNavigationButtonsTop'}
		</ul>
	</nav>
</div>

{if $objects|count}
	<div id="trackingProviderTableContainer" class="tabularBox tabularBoxTitle marginTop">
		<header>
			<h2>{lang}wcf.acp.tracking.provider.list{/lang} <span class="badge badgeInverse">{#$items}</span></h2>
		</header>

		<table data-type="com.mrk.wcf.tracking.provider" class="table jsClipboardContainer">
			<thead>
				<tr>
					<th class="columnMark"><label><input type="checkbox" class="jsClipboardMarkAll" /></label></th>
					<th class="columnID{if $sortField == 'trackingProviderID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='TrackingProviderList'}pageNo={@$pageNo}&sortField=trackingProviderID&sortOrder={if $sortField == 'trackingProviderID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle{if $sortField == 'providerName'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingProviderList'}pageNo={@$pageNo}&sortField=providerName&sortOrder={if $sortField == 'providerName' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.provider.providerName{/lang}</a></th>
					<th class="columnURL{if $sortField == 'trackingURL'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingProviderList'}pageNo={@$pageNo}&sortField=trackingURL&sortOrder={if $sortField == 'trackingURL' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.provider.trackingURL{/lang}</a></th>
					<th class="columnStatus{if $sortField == 'trackingID'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingProviderList'}pageNo={@$pageNo}&sortField=trackingID&sortOrder={if $sortField == 'trackingID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.provider.trackingID{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>

			<tbody>
				{foreach from=$objects item=trackingProvider}
					<tr class="jsTrackingProviderRow">
						<td class="columnMark"><input type="checkbox" class="jsClipboardItem" data-object-id="{$trackingProvider->trackingProviderID}" /></td>
						<td class="columnIcon">
							<span class="icon icon16 icon-check{if $trackingProvider->isDisabled}-empty{/if} jsToggleButton jsTooltip pointer" title="{lang}wcf.global.button.{if !$trackingProvider->isDisabled}disable{else}enable{/if}{/lang}" data-object-id="{@$trackingProvider->trackingProviderID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"></span>
							<a href="{link controller='TrackingProviderEdit' object=$trackingProvider}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
							<span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$trackingProvider->trackingProviderID}" data-confirm-message="{lang}wcf.acp.tracking.provider.delete.sure{/lang}"></span>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID">{@$trackingProvider->trackingProviderID}</td>
						<td class="columnTitle">{$trackingProvider->providerName}</td>
						<td class="columnURL">{if $trackingProvider->trackingURL}<a href="{@$__wcf->getPath()}acp/dereferrer.php?url={$trackingProvider->getTrackingURL()}" target="_blank">{$trackingProvider->trackingURL}</a>{else}<span class="badge red">{lang}wcf.acp.tracking.provider.notRequired{/lang}</span>{/if}</td>
						<td class="columnStatus">{if $trackingProvider->trackingID}<span class="badge green">{@$trackingProvider->trackingID}</span>{else}<span class="badge red">{lang}wcf.acp.tracking.provider.notRequired{/lang}</span>{/if}</td>
						
						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

<div class="contentNavigation">
	{@$pagesLinks}
	
	<nav>
		<ul>
			<li><a href="{link controller='TrackingProviderStart'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.tracking.provider.add{/lang}</span></a></li>

			{event name='contentNavigationButtonsBottom'}
		</ul>
	</nav>
	<nav class="jsClipboardEditor" data-types="[ 'com.mrk.wcf.tracking.provider' ]"></nav>
</div>

{include file='footer'}

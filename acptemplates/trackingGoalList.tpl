{include file='header' pageTitle='wcf.acp.tracking.goal.list'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.tracking.goal.list{/lang}</h1>
</header>

<script data-relocate="true" src="{@$__wcf->getPath('wcf')}js/WCF.Tracking{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Tracking.GoalList.Toggle('wcf\\data\\tracking\\goal\\TrackingGoalAction', '.jsTrackingGoalRow');
		new WCF.Action.Delete('wcf\\data\\tracking\\goal\\TrackingGoalAction', '.jsTrackingGoalRow');
		new WCF.Tracking.GoalList.SelectProvider();
		
		var options = { };
		{if $pages > 1}
			options.refreshPage = true;
			{if $pages == $pageNo}options.updatePageNumber = -1;{/if}
		{else}
			options.emptyMessage = '{lang}wcf.global.noItems{/lang}';
		{/if}
		new WCF.Table.EmptyTableHandler($('#trackingGoalTableContainer'), 'jsTrackingGoalRow', options);
	});
	//]]>
</script>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="TrackingGoalList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	<nav>
		<ul>
			<li><a href="{link controller='TrackingGoalAdd'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.tracking.goal.add{/lang}</span></a></li>
			
			{event name='contentNavigationButtonsTop'}
		</ul>
	</nav>
</div>

<form id="goalTrackingProvider">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.tracking.provider{/lang}</legend>
			<dl>
				<dt><label for="trackingProvider">{lang}wcf.acp.tracking.provider{/lang}</label></dt>
				<dd>
					<select id="trackingProvider" name="trackingProvider">
						<option value="">{lang}wcf.global.noSelection{/lang}</option>
						{foreach from=$trackingProviders item=trackingProvider}
							<option value="{$trackingProvider->trackingProviderID}"{if TRACKING_GOAL_PROVIDER == $trackingProvider->trackingProviderID} selected="selected"{/if}>{lang}{@$trackingProvider->providerName}{/lang}</option>
						{/foreach}
					</select>
					<small{if $trackingProviderInvalid} class="innerError"{/if}>{lang}wcf.acp.tracking.goal.trackingProvider.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>
	</div>

	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{if $objects|count}
	<div id="trackingGoalTableContainer" class="tabularBox tabularBoxTitle marginTop">
		<header>
			<h2>{lang}wcf.acp.tracking.goal.list{/lang} <span class="badge badgeInverse">{#$items}</span></h2>
		</header>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID{if $sortField == 'trackingGoalID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='TrackingGoalList'}pageNo={@$pageNo}&sortField=trackingGoalID&sortOrder={if $sortField == 'trackingGoalID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle{if $sortField == 'goalName'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingGoalList'}pageNo={@$pageNo}&sortField=goalName&sortOrder={if $sortField == 'goalName' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.goal.goalName{/lang}</a></th>
					<th class="columnText{if $sortField == 'description'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingGoalList'}pageNo={@$pageNo}&sortField=description&sortOrder={if $sortField == 'description' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.goal.description{/lang}</a></th>
					<th class="columnStatus{if $sortField == 'trackingID'} active {@$sortOrder}{/if}"><a href="{link controller='TrackingGoalList'}pageNo={@$pageNo}&sortField=trackingID&sortOrder={if $sortField == 'trackingID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.tracking.goal.trackingID{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=trackingGoal}
					<tr class="jsTrackingGoalRow">
						<td class="columnIcon">
							<a href="{link controller='TrackingGoalEdit' object=$trackingGoal}{/link}" class="icon icon16 icon-check{if $trackingGoal->isDisabled}-empty{/if} jsToggleButton jsTooltip pointer" title="{lang}wcf.global.button.{if !$trackingGoal->isDisabled}disable{else}enable{/if}{/lang}" data-object-id="{@$trackingGoal->trackingGoalID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"{if $trackingGoal->trackingID} data-valid="1"{/if}></a>
							<a href="{link controller='TrackingGoalEdit' object=$trackingGoal}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
							<span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$trackingGoal->trackingGoalID}" data-confirm-message="{lang}wcf.acp.tracking.goal.delete.sure{/lang}"></span>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID">{@$trackingGoal->trackingGoalID}</td>
						<td class="columnTitle">{$trackingGoal->goalName}</td>
						<td class="columnText">{$trackingGoal->description|language}</td>
						<td class="columnStatus">{if $trackingGoal->trackingID}<span class="badge green">{$trackingGoal->trackingID}</span>{else}<span class="badge red">{lang}wcf.acp.tracking.goal.notSet{/lang}</span>{/if}</td>
						
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
			<li><a href="{link controller='TrackingGoalAdd'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.tracking.goal.add{/lang}</span></a></li>

			{event name='contentNavigationButtonsBottom'}
		</ul>
	</nav>
</div>

{include file='footer'}

<script type="text/javascript">
	var _paq = _paq || [];
	_paq.push(["trackPageView"]);
	_paq.push(["enableLinkTracking"]); <!-- com.mrk.wcf.tracking.goal.codePlaceholder -->
	
	(function() {
		var u=(("https:" == document.location.protocol) ? "https" : "http") + "://{@$trackingURL}";
		_paq.push(["setTrackerUrl", u+"piwik.php"]);
		_paq.push(["setSiteId", "{$trackingID}"]);
		var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
		g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
	})();
</script>
<noscript><img src="http://localhost/piwik/piwik.php?idsite={$trackingID}&amp;rec=1" style="border:0" alt="" /></noscript>

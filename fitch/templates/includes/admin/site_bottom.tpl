{strip}

			</div>
		
		</div><!--div class="site-wrap"-->
		
		<footer class="site-footer">
			Copyright &copy; <a href="/">{$web_config.company_name}</a>, {$smarty.now|date_format:"%Y"}. All rights reserved.
			<br />
			The <a href="http://www.npgroup.net/" target="_blank">New Possibilities Group</a> Framework.
		</footer>
		<script>
			var isLoggedInHelpDesk = {if isset($smarty.session.user) && $smarty.session.user && $smarty.session.user->is_admin}1{else}0{/if};
			var adminEmailLoggedInHelpDesk = '{if isset($smarty.session.user) && $smarty.session.user && $smarty.session.user->is_admin && $smarty.session.user->email}{$smarty.session.user->email|escape}{/if}';
			var scriptTag = document.createElement("script");
			scriptTag.type = "text/javascript";
			scriptTag.src = "https://d2xvw076a3h8ws.cloudfront.net/script.js";
			scriptTag.setAttribute("data-zoom-id", "2014674288");
			scriptTag.setAttribute("data-user-name", "");
			scriptTag.setAttribute("async", "");
			( document.getElementsByTagName("head")[0] || document.documentElement ).appendChild( scriptTag );
		</script>
	</body>
</html>

{/strip}
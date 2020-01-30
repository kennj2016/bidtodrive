{strip}

<div class="popup-wrap{if $fixed} fixed{/if}">
	{if $fixed}
		<div class="popup-overlay"></div>
	{/if}
	<div class="popup-box {if $type eq 'error'}red{elseif $type eq 'success'}green{else}blue{/if}">
		<div class="popup-content">
			<div class="popup-heading">
				<span>
					{if $title}
						{$title|escape}
					{elseif $type eq 'error'}
						error
					{elseif $type eq 'success'}
						success
					{else}
						info
					{/if}
				</span>
				<a class="popup-close" href="#"></a>
			</div>
			<div class="popup-text">
				<p>
					{$message}
				</p>
			</div>
		</div>
	</div>
</div>

{/strip}
{strip}
    <div class="visualhidden popverify">
        <div class="popup-box">
            <div class="content file-upload-pop">
                <div class="header-box">
                    <div class="name">
                        <span>Confirmation</span>
                    </div>
                    <span class="close">
                        <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                    </span>
                </div>
                <div class="context">
                    <div>
                        {if $smarty.request.action == "admin-verify"}
                            <p>Account has been verified.</p>
                        {else}
                            <p>Your account has been verified.</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/strip}
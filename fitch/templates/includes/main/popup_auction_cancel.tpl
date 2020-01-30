{strip}
    <div class="visualhidden popverify" id="cancel-popup-box">
        <div class="popup-box">
            <div class="content file-upload-pop">
                <div class="header-box">
                    <div class="name">
                        <span>Are you sure you want to cancel this auction?</span>
                    </div>
                    <span class="close-custom">
                        <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                    </span>
                </div>
                <div class="context">
                    <form action="" method="POST" id="cancel-auction-form">
                        <input type="hidden" name="action" value="cancel-auction">
                        <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                        <p id="cancel-auction-err" style="display:none; color:red; padding:0; margin:0;"></p>
                        <div class="cancel-popup-btns">
                            <button class="btn blue first-btn" id="popup-cancel-yes">Yes</button>
                            <button class="btn blue second-btn">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/strip}
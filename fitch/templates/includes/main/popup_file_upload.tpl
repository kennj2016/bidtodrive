{strip}
    <div class="visualhidden">
        <div class="popup-box">
            <div class="content file-upload-pop">
                <div class="header-box">
                    <div class="name">
                        <span>File{if $upload} Upload{/if} Preview</span>
                    </div>
                    <span class="close">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             version="1.1" viewBox="0 0 21.9 21.9" enable-background="new 0 0 21.9 21.9"
                             width="512px" height="512px" class="svg-icon-inject  replaced-svg"
                             data-url="/images/icons/cancel.svg">
                            <path class="ic"
                                  d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"
                                  fill="#FFFFFF"></path>
                        </svg>
                    </span>
                </div>
                <div class="context">
                    <figure class="uploaded-img-holder">
                        <img src="/images/bg/license.jpg" alt="license" title="license"/>
                    </figure>
                    {if $upload}
                        <div class="center-buttons">
                            <button type="button" class="btn-2 blue">Upload new file</button>
                            <button type="button" class="btn-2 black">ok</button>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/strip}
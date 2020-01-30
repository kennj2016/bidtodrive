<div class="page {if $parameters.action == "account_info"}active{/if}">
    <h4 class="head-title">
        <div class="ico">
            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account infomation" title="My account infomation"/>
        </div>
        <span>My account infomation</span>
    </h4>
    <div class="subpage">
        <form action="" method="post" class="form" autocomplete="off">
            <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
            <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
            <div class="field-block-1">
                <div class="block-1">
                    <label>Personal Information</label>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">Name</label>
                    <input type="text" name="name" class="text" placeholder="Name" value="{$parameters.user->name|escape}"/>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">Email</label>
                    <input type="text" name="email" value="" style="display: none" />
                    <input type="text" name="email" class="text" placeholder="Email" value="{$parameters.user->email|escape}"/>
                    <input type="text" name="not-an-email" value="" style="display: none" />
                </div>
                <div class="block-1 label-holder">
                    <label class="small">Address</label>
                    <input type="tel" class="text" placeholder="" name="address" value="{$parameters.user->address}"/>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">City</label>
                    <input type="text" class="text" placeholder="" name="city" value="{$parameters.user->city}"/>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">State</label>
                    <select name="state" class="text" placeholder="">
                        <option value=""></option>
                        {if $parameters.states}
                            {foreach from=$parameters.states item=item}
                                <option value="{$item->abbr}" {if $parameters.user->state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                            {/foreach}
                        {/if}
                    </select>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">Zip Code</label>
                    <input type="tel" class="text" placeholder=""  name="zip" value="{$parameters.user->zip}"/>
                </div>
                <div class="block-3 block-3-until-mob label-holder">
                    <label class="small">Mobile number</label>
                    <input type="tel" class="text phone_mask" placeholder="Mobile number" name="mobile_number" value="{$parameters.user->mobile_number|escape}"/>
                </div>
                <div class="block-1">
                    <label>Upload profile photo</label>
                </div>
                <div class="block-1 drag-file-upload">
                    <div id="dropzone-profile">
                        <div class="title-box">
                            <div>
                                <strong>Upload</strong>
                                <span>your files here</span>
                                <span class="btn-2 blue">Choose File</span>
                            </div>
                        </div>
                        {if $parameters.user->profile_photo_info}
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete dz-preview-profile_photo_info">
                                <div class="dz-image">
                                    <img data-dz-thumbnail="" alt="{$parameters.user->profile_photo_info->name_orig|escape}" src="/site_media/{$parameters.user->profile_photo}/m/" title="{$parameters.user->profile_photo_info->name_orig|escape}" />
                                </div>
                                <div class="dz-details">
                                    <div class="dz-filename">
                                        <span data-dz-name="">{$parameters.user->profile_photo_info->name_orig|escape}</span>
                                    </div>
                                </div>
                                <div class="dz-progress" style="display: none;">
                                    <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                </div>
                                <div class="dz-success-mark popup"
                                     data-file_id="{$parameters.user->profile_photo}">
                                    <svg version="1.1" width="20px" height="20px"                          id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         x="0px" y="0px" viewBox="0 0 52.669 52.669"
                                         style="enable-background:new 0 0 52.669 52.669;"
                                         xml:space="preserve">        <g>
                                            <g>
                                                <path d="M33.463,42.496c-7.284,0-13.474-4.75-15.649-11.313H9.05v-3.232h8.045c-0.075-0.637-0.118-1.283-0.118-1.94            c0-0.879,0.071-1.742,0.204-2.585H9.05v-3.232h8.99c0.625-1.651,1.508-3.175,2.599-4.525H9.05v-3.232h15.075v-0.002              c2.656-1.833,5.873-2.909,9.337-2.909c2.106,0,4.119,0.401,5.972,1.124V2.415H0v41.374c0,3.556,2.909,6.465,6.465,6.465H32.97           c3.556,0,6.465-2.909,6.465-6.465v-2.417C37.582,42.095,35.569,42.496,33.463,42.496z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M44.488,33.36c1.405-2.104,2.226-4.631,2.226-7.35c0-7.319-5.933-13.252-13.253-13.252            c-7.321,0-13.253,5.933-13.253,13.252c0,7.319,5.931,13.253,13.253,13.253c2.965,0,5.693-0.985,7.9-2.63l8.109,8.109l3.199-3.2            L44.488,33.36z M33.462,36.031c-5.525,0-10.02-4.495-10.02-10.021c0-5.525,4.495-10.02,10.02-10.02            c5.525,0,10.02,4.495,10.02,10.02C43.482,31.535,38.988,36.031,33.462,36.031z"></path>
                                            </g>
                                        </g>    </svg>
                                    <title>Check</title>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1"
                                       fill="none" fill-rule="evenodd"
                                       sketch:type="MSPage">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                              id="Oval-2" stroke-opacity="0.198794158"
                                              stroke="#747474"
                                              fill-opacity="0.816519475" fill="#FFFFFF"
                                              sketch:type="MSShapeGroup"></path>
                                    </g>
                                </div>
                                <div class="dz-error-mark">
                                    <svg width="12px" height="12px" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 21.9 21.9"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         enable-background="new 0 0 21.9 21.9">
                                        <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
                                    </svg>
                                </div>
                                <input type="hidden" name="profile_photo" value="{$parameters.user->profile_photo}">
                            </div>
                        {/if}
                    </div>
                </div>
                <div class="block-1">
                    <label>Dealers License Information</label>
                </div>
                <div class="block-1 label-holder">
                    <label class="small">Issued to</label>
                    <input type="tel" class="text" placeholder="Issued to" name="dealers_license_issued_to" value="{$parameters.user->dealers_license_issued_to|date_format:"%m.%d.%Y"}"/>
                </div>
                <div class="block-2 label-holder">
                    <label class="small">State</label>
                    <select name="dealers_license_state" class="text" placeholder="">
                        <option value=""></option>
                        {if $parameters.states}
                            {foreach from=$parameters.states item=item}
                                <option value="{$item->abbr}" {if $item->abbr == $parameters.user->dealers_license_state} selected=""{/if}>{$item->name}</option>
                            {/foreach}
                        {/if}
                    </select>
                </div>
                <div class="block-2 label-holder">
                    <label class="small">License Number</label>
                    <input type="tel" class="text" placeholder="License Number" name="dealers_license_number" value="{$parameters.user->dealers_license_number|escape}"/>
                </div>
                <div class="block-2 label-holder">
                    <label class="small">Issue Date</label>
                    <input type="tel" class="text date_mask" placeholder="Issue Date" name="dealers_license_issue_date" value="{$parameters.user->dealers_license_issue_date|date_format:"%m.%d.%Y"}"/>
                </div>
                <div class="block-2 label-holder">
                    <label class="small">Expiration Date</label>
                    <input type="tel" class="text date_mask" placeholder="Expiration Date" name="dealers_license_expiration_date" value="{$parameters.user->dealers_license_expiration_date|date_format:"%m.%d.%Y"}"/>
                </div>
                <div class="block-1">
                    <label>Upload Dealers License</label>
                </div>
                <div class="block-1 drag-file-upload">
                    <div id="dropzone-dealer-license">
                        <div class="title-box">
                            <div>
                                <strong>Upload</strong>
                                <span>your files here</span>
                                <span class="btn-2 blue">Choose File</span>
                            </div>
                        </div>
                        {if $parameters.user->dealers_license_photo_info}
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete dz-preview-dealers_license_photo_info">
                                <div class="dz-image">
                                    <img data-dz-thumbnail="" alt="{$parameters.user->dealers_license_photo_info->name_orig|escape}" src="/license/ml/{$parameters.user->dealers_license_photo_info->name_new}" title="{$parameters.user->dealers_license_photo_info->name_orig|escape}" />
                                </div>
                                <div class="dz-details">
                                    <div class="dz-filename">
                                        <span data-dz-name="">{$parameters.user->dealers_license_photo_info->name_orig|escape}</span>
                                    </div>
                                </div>
                                <div class="dz-progress" style="display: none;">
                  <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                </div>
                                <div class="dz-success-mark popup" data-file_id="{$parameters.user->dealers_license_photo_info->name_new}">
                                    <svg version="1.1" width="20px" height="20px"
                                         id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         x="0px" y="0px" viewBox="0 0 52.669 52.669"
                                         style="enable-background:new 0 0 52.669 52.669;"
                                         xml:space="preserve">        <g>
                                            <g>
                                                <path d="M33.463,42.496c-7.284,0-13.474-4.75-15.649-11.313H9.05v-3.232h8.045c-0.075-0.637-0.118-1.283-0.118-1.94            c0-0.879,0.071-1.742,0.204-2.585H9.05v-3.232h8.99c0.625-1.651,1.508-3.175,2.599-4.525H9.05v-3.232h15.075v-0.002              c2.656-1.833,5.873-2.909,9.337-2.909c2.106,0,4.119,0.401,5.972,1.124V2.415H0v41.374c0,3.556,2.909,6.465,6.465,6.465H32.97           c3.556,0,6.465-2.909,6.465-6.465v-2.417C37.582,42.095,35.569,42.496,33.463,42.496z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M44.488,33.36c1.405-2.104,2.226-4.631,2.226-7.35c0-7.319-5.933-13.252-13.253-13.252            c-7.321,0-13.253,5.933-13.253,13.252c0,7.319,5.931,13.253,13.253,13.253c2.965,0,5.693-0.985,7.9-2.63l8.109,8.109l3.199-3.2            L44.488,33.36z M33.462,36.031c-5.525,0-10.02-4.495-10.02-10.021c0-5.525,4.495-10.02,10.02-10.02            c5.525,0,10.02,4.495,10.02,10.02C43.482,31.535,38.988,36.031,33.462,36.031z"></path>
                                            </g>
                                        </g>    </svg>
                                    <title>Check</title>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1"
                                       fill="none" fill-rule="evenodd"
                                       sketch:type="MSPage">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                              id="Oval-2" stroke-opacity="0.198794158"
                                              stroke="#747474"
                                              fill-opacity="0.816519475" fill="#FFFFFF"
                                              sketch:type="MSShapeGroup"></path>
                                    </g>
                                </div>
                                <div class="dz-error-mark">
                                    <svg width="12px" height="12px" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 21.9 21.9"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         enable-background="new 0 0 21.9 21.9">
                                        <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
                                    </svg>
                                </div>
                                <input type="hidden" name="dealers_license_photo" value="{$parameters.user->dealers_license_photo}">
                            </div>
                        {/if}
                    </div>
                </div>
                <hr class="hr"/>
                <div class="block-1 flex-h-left sumbit-info-btn">
                    <input type="submit" class="submit-right btn-2 blue " value="Update Information"/>
                </div>
            </div>
        </form>
    </div>
</div>
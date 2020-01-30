{strip}
{include file="includes/main/site_top.tpl"}
<style>
{literal}
.footer{
  display: none !important;
}
{/literal}
</style>
<div class="container" style="margin-top:100px;">
  <div class="row col-6" style="float:left;">
    <div class="form">
      <form>
        <input name="vin" value="{$smarty.request.vin}" class="text" placeholder="Enter VIN code" />
        <button style="margin-left: 10px;"  class="submit btn-2 blue" type="submit">Submit</button>
        {if $parameters.result}
          {if $parameters.auction_result}
            <button  class="submit btn-2 black" style="cursor:default;" type="button">Saved!</button>
          {else}
            <input class="submit btn-2 black" type="submit" name="save" value="save">
          {/if}
        {/if}
      </form>
    </div>
  </div>
  {if $smarty.request.vin}
  <div class="row col-18" style="float:right;">
    <h3>Results for: {$smarty.request.vin}</h3>
    {if $parameters.result}
      <div class="row col-18">
        <div class="row col-18">
          <div class="row col-4" style="float:left;"><strong>Prop</strong></div>
          <div class="row col-8"><strong>Value</strong></div>
        </div>
        {foreach from=$parameters.result item=item key=key}
          <div class="row col-18">
            <div class="row col-4" style="float:left;"><strong>{$key}</strong></div>
            <div class="row col-8" style="float:left;"><strong style="color: #0650cb;">{if $item}{$item}{else}-{/if}</strong></div>
          </div>
        {/foreach}
      </div>
    {else}
      <div class="row col-18" style="width:100%;">
        <h2 >There are no data found.</h2>
      </div>
    {/if}
  </div>
  {/if}
</div>
{include file="includes/main/site_bottom.tpl"}
{/strip}
{***
old API
<script type="text/javascript" src="http://www.carqueryapi.com/js/jquery.min.js"></script>
<script type="text/javascript" src="http://www.carqueryapi.com/js/carquery.0.3.4.js"></script>
<div class="entry-content clearfix">
  <p>
    {literal}
    <script type="text/javascript">
      $(document).ready( function() {
      var carquery = new CarQuery();
      carquery.init();
      /*carquery.initYearMakeModel('car-years', 'car-makes', 'car-models');
      carquery.initYearMakeModelTrim('car-years', 'car-makes', 'car-models', 'car-model-trims');*/
      carquery.initSearchInterface();
      //Set onclick function for the search button
      $('#cq-search-btn').click( function(){ carquery.search(); } );
      });
    </script>
    {/literal}
  </p>
  <hr />
  <div id="cq-search-controls">
    <div style="float:left; width:300px;">
      <fieldset>
        <p>	
        <center><input type="button" id="cq-search-btn" value="Search CarQuery" /></center>
        </p>
        <hr/>
        Keyword: <input id="cq-search-input" type="text" /></p>
        <hr/>
        Year Range: <select id="cq-min-year"></select> to <select id="cq-max-year"></select><br />
        </p>
        <hr/>
        <input id="cq-sold-in-us" name="us-only-filter" type="checkbox" /><label for="us-only-filter">Show Only US Models</label><br />
        </p>
        <hr/>
        Body Style: <select id="cq-body"></select><br />
        </p>
        <hr/>
        Engine Position: <select id="cq-engine-position"></select><br />
        </p>
        <hr/>
        Engine Type: <select id="cq-engine-type"></select><br />
        </p>
        <hr/>
        Engine Cylinders: <select id="cq-min-cylinders"></select> to <select id="cq-max-cylinders"></select><br />
        </p>
        <hr/>
        Engine Power (hp): <input type="text" id="cq-min-power" style="width:30px" /> to <input type="text" id="cq-max-power" style="width:30px" /><br />
        </p>
        <hr/>
        Engine Torque (lb-ft): <input type="text" id="cq-min-torque" style="width:30px" /> to <input type="text" id="cq-max-torque" style="width:30px" /><br />
        </p>
        <hr/>
        Engine Fuel Type: <select id="cq-fuel-type"></select><br />
        </p>
        <hr/>
        Top Speed (mph): <input type="text" id="cq-min-top-speed" style="width:30px" /> to <input type="text" id="cq-max-top-speed" style="width:30px" /><br />
        </p>
        <hr/>
        Drivetrain: <select id="cq-drive"></select><br />
        </p>
        <hr/>
        Seats: <select id="cq-seats"></select><br />
        </p>
        <hr/>
        Doors: <select id="cq-doors"></select><br />
        </p>
        <hr/>
        Weight (lbs): <input type="text" id="cq-min-weight" style="width:30px" /> to <input type="text" id="cq-max-weight" style="width:30px" /></p>
      </fieldset>
    </div>
    <div style="float:left;width:300px;">
      <fieldset>
        <div id="cq-search-results">
          Search Results:
        </div>
      </fieldset>
    </div>
  </div>
  <div id="cq-search-result" style="display:none"></div>
</div>
***}
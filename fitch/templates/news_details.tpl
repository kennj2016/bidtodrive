{strip}
{include file="includes/main/site_top.tpl"}
<div class="row no-gutters bg-image" {if $parameters.settings->hero_image}style="background-image:url(/site_media/{$parameters.settings->hero_image}/);"{/if}>
  <div class="container">
    <div class="col-24">
      <div class="module-hero-2">
        <div class="content">
          {if $parameters.record->title}<h3 class="title">{$parameters.record->title}</h3>{/if}
          <p>{$parameters.record->datetime_publish|date_format|upper}{if $parameters.record->author && $parameters.record->datetime_publish} | {/if}{if $parameters.record->author}{$parameters.record->author}{/if}</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row no-gutters bg-grey">
  <div class="container">
    <div class="col-24">
      <div class="breadcrumbs">
        <p>
          <a href="/" class="home" title="Homepage">
            <img class="svg-icon-inject" src="/images/icons/icon-home.svg" alt="{$parameters.record->title}" title="{$parameters.record->title}"/>
          </a> 
          {if $parameters.settings->breadcrumbs}
            <a href="/news/" title="News">{$parameters.settings->breadcrumbs} </a> 
          {/if}
          {$parameters.record->title}
        </p>
      </div>
    </div>
  </div>
</div>


<div class="row flex no-gutters">
  <div class="container">
    <div class="col-24">
      <div class="news-detail">
        <div class="content">
          <div class="header-box">
            {if $parameters.record->datetime_publish || $parameters.record->author}
              <div class="date-stamp">
                <div>{$parameters.record->datetime_publish|date_format|upper}{if $parameters.record->author && $parameters.record->datetime_publish} | {/if}{if $parameters.record->author}<a class="fake-link" title="{$parameters.record->author}" href="/news/author/{$parameters.record->author_url_title}/">{$parameters.record->author}</a>{/if}</div>
              </div>
            {/if}
            {if $parameters.record->category}
              <a href="/news/category/{$parameters.record->category_url_title}/" title="{$parameters.record->category}" class="fake-link news-label">
                {$parameters.record->category}
              </a>
            {/if}
          </div>
          {$parameters.record->description}
          <br/>
          <h6>SHARE</h6>
          <br/>
          <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a33da216df8e6ce"></script>
          <!-- Go to www.addthis.com/dashboard to customize your tools --> 
          <div class="addthis_inline_share_toolbox"></div>
        </div>
      </div>
    </div>
  </div>
</div>
{if $parameters.recent_news}
  <div class="row flex no-gutters">
    <div class="container flex-h-center">
      <div class="col-24">
        <div class="news-listing">
          <div class="container">
            <h5 class="subtitle">Related Reading</h5>
            <div class="listing-1 balancer">
              {foreach name=records from=$parameters.recent_news item=item}
                <div class="item">
                  <div class="content">
                    {if $item->category}
                      <a href="/news/category/{$item->category_url_title}/" class="fake-link news-label" title="{$item->category}" >
                        {$item->category}
                      </a>
                    {/if}
                    <div class="date-stamp">
                      <div>{$item->datetime_publish|date_format|upper}{if $item->author && $item->datetime_publish} | {/if}{if $item->author}<a class="fake-link" href="/news/author/{$item->author_url_title}/" title="{$item->author}">{$item->author}</a>{/if}</div>
                    </div>
                    <div class="box">
                      <a href="/news/{$item->url_title}/"><h2 class="title fake-link" data-link="/news/{$item->url_title}/" title="{$item->title}">{$item->title}</h2></a>
                      <div class="stamp">
                        <p>{$item->description|strip_tags|truncate:"350"}</p>
                      </div>
                    </div>
                    <a href="/news/{$item->url_title}/" class="btn-1 blue fake-link" title="continue">continue</a>
                  </div>
                  <a class="bg-image-add " href="/news/{$item->url_title}/" {if $item->image}style="background-image: url('/site_media/{$item->image}/n/');"{/if} title="Image"></a>
                  
                </div>
              {/foreach}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
{/if}

{include file="includes/main/site_bottom.tpl"}
{/strip}
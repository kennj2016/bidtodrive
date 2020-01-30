{strip}
{include file="includes/main/site_top.tpl"}
  <div class="row no-gutters bg-image" {if $parameters.settings->hero_image}style="background-image:url(/site_media/{$parameters.settings->hero_image}/l/);"{/if}>
    <div class="container">
      <div class="col-24">
        <div class="module-hero-2">
          <div class="content">
            {if $parameters.settings->title}<h3 class="title">{$parameters.settings->title}{if $parameters.settings->breadcrumbs2}: {$parameters.settings->breadcrumbs2}{/if}</h3>{/if}
            {if $parameters.settings->subtitle}<p>{$parameters.settings->subtitle}</p>{/if}
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
              <img class="svg-icon-inject" src="/images/icons/icon-home.svg" alt="{$parameters.settings->breadcrumbs}" title="{$parameters.settings->breadcrumbs}"/>
            </a> 
            {if $parameters.settings->breadcrumbs}
              <a href="/news/" title="Breadcrumbs">{$parameters.settings->breadcrumbs} </a> 
              {$parameters.settings->breadcrumbs} listing{if $parameters.settings->breadcrumbs2}: {$parameters.settings->breadcrumbs2}{/if}
            {/if}
          </p>
        </div>
      </div>
    </div>
  </div>
  <div id="filters-form" class="row flex no-gutters border-1 scroll-to">
    <div class="container flex-h-center">
      <div class="col-24 lock">
        <div class="cpt-filter">
          <div class="container">
            <form class="form" id="news_search_form">
              <div class="block-2 blog-search">
                <input type="search" name="keyword" value="{$smarty.request.keyword}" placeholder="Search posts...">
              </div>
              <div class="filter-box-opener">
                <div class="icon">
                  <img class="svg-icon-inject" src="/images/icons/icons-30.svg" alt="" />
                </div>
              </div>
              <div class="block-2 filter-box">
                <div class="closer">
                  <div>
                    <span class="name">Filters</span>
                    <div class="icon close">
                      <img class="svg-icon-inject" src="/images/icons/nav-close.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div class="block-3">
                  <select class="select-3 cat" name="category_id" placeholder="All Categories">
                    <option value="">All Categories</option>
                    {if $parameters.categories}
                      {foreach from=$parameters.categories item=item}
                        <option value="{$item->id}" {if $parameters.settings->selected_category && $parameters.settings->selected_category == $item->id}selected=""{/if}>{$item->title}</option>
                      {/foreach}
                    {/if}
                  </select>
                </div>
                <div class="block-3">
                  <select class="select-3 sort" name="sort" placeholder="Date">
                    <option value="date">Date</option>
                    <option value="category">Category</option>
                  </select>
                  <input type="hidden" name="page" value="1" />
                </div>
                <div class="block-3 news-mobile-apply-filter-box" style="display:none;">
                  <a href="javascript:void(0);" class="btn-2 blue news-mobile-apply-filter" title="Apply">Apply</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="list-wrapper">
    {include file="news_list.tpl"}
  </div>
{include file="includes/main/site_bottom.tpl"}
{/strip}
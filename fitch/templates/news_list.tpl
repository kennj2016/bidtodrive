{strip}
  {if $parameters.records}
    <div class="row flex no-gutters">
      <div class="container flex-h-center">
        <div class="col-24">
          <div class="news-listing">
            <div class="container">
              <div class="listing-1 balancer">
                {foreach name=records from=$parameters.records item=item}
                  {if $smarty.foreach.records.index == 0 && $parameters.page == 1}
                    <div class="item large">
                      <div class="content">
                        <a href="/news/category/{$item->category_url_title}/" class="fake-link news-label" title="{$item->category}">
                          {$item->category}
                        </a>
                        <div class="date-stamp">
                          <div>{$item->datetime_publish|date_format|upper}{if $item->author && $item->datetime_publish} | {/if}{if $item->author}<a class="fake-link" href="/news/author/{$item->author_url_title}/" title="{$item->author}">{$item->author}</a>{/if}</div>
                        </div>
                        <div class="box">
                          <a href="/news/{$item->url_title}/" title="{$item->title}"><h2 class="title fake-link" data-link="/news/{$item->url_title}/">{$item->title}</h2></a>
                          <div class="stamp">
                            <p>{$item->description|strip_tags|truncate:"600"}</p>
                          </div>
                        </div>
                        <a class="btn-1 blue fake-link" href="/news/{$item->url_title}/" title="continue">continue</a>
                      </div>
                      <a href="/news/{$item->url_title}/" class="bg-image-add" {if $item->image}style="background-image: url('/site_media/{$item->image}/');"{/if} title="Image"></a>
                    </div>
                  {else}
                    <div class="item">
                      <div class="content">
                        {if $item->category}
                          <a href="/news/category/{$item->category_url_title}/" class="fake-link news-label" title="{$item->category}">
                            {$item->category}
                          </a>
                        {/if}
                        <div class="date-stamp">
                          <div>{$item->datetime_publish|date_format|upper}{if $item->author && $item->datetime_publish} | {/if}{if $item->author}<a class="fake-link" href="/news/author/{$item->author_url_title}/" title="{$item->author}">{$item->author}</a>{/if}</div>
                        </div>
                        <div class="box">
                          <a href="/news/{$item->url_title}/" title="{$item->title}"><h2 class="title fake-link" data-link="/news/{$item->url_title}/" >{$item->title}</h2></a>
                          <div class="stamp">
                            <p>{$item->description|strip_tags|truncate:"350"}</p>
                          </div>
                        </div>
                        <a href="/news/{$item->url_title}/" class="btn-1 blue fake-link" title="continue">continue</a>
                      </div>
                      <a href="/news/{$item->url_title}/" title="Image" class="bg-image-add" {if $item->image}style="background-image: url('/site_media/{$item->image}/n/');"{/if}></a>
                    </div>
                  {/if}
                {/foreach}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {if $parameters.count_pages}
      <div class="row flex no-gutters">
        <div class="container flex-h-center">
          <div class="col-24">
            <div class="pagination">
              <div class="container">
                <a data-page="{$parameters.page-1}" href="#" title="prev" class="prev {if $parameters.page == 1}disabled{/if}">
                    <img class="svg-icon-inject" src="/images/icons/left-arrow.svg" alt="Prev Article" title="Prev Article" />
                </a>
                <input readonly="" type="text" class="number" value="{$parameters.page}"/>
                <a data-page="{$parameters.page+1}" title="next" href="#" class="next {if $parameters.page == $parameters.count_pages}disabled{/if}">
                    <img class="svg-icon-inject" src="/images/icons/right-arrow.svg" alt="Next Article" alt="Next Article"/>
                </a>
                <span class="of">
                <span>of</span>
                <mark>{$parameters.count_pages}</mark>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/if}
  {else}
    <div class="row flex no-gutters">
      <div class="container flex-h-center">
        <div class="col-24">
          <h3 style="padding: 1em 0.5em;">No posts found matching your search criteria.</h3>
        </div>
      </div>
    </div>
  {/if}
{/strip}
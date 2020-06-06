<header class="clearfix serendipity_entry">
{foreach from=$categories item=$cat}
    <h2>{$CONST.CATEGORY}: {$cat.category_name|escape}</h2>
    {if $cat.category_icon || $cat.category_description}
    <div class='categorydesc'>
    {if $cat.category_icon}<div class='categoryimage'><img src="{$cat.category_icon}" alt="{$cat.category_name}" float="left" /></div>{/if}
    <div class='categorydescription'>{$cat.category_description}</div>
    </div>
    {/if}
    {if $cat.xmlimage || $cat.mailimage}
    <h3>{$CONST.SUBSCRIBE}</h3>
    <div>
    {if $cat.xmlimage }
    <a class="serendipity_xml_icon" href="{$cat.feedURL}" title="{$CONST.FEED_OF_TITLE|sprintf:"{$cat.category_name|escape}"}"><img src="{$cat.xmlimage}" alt="XML" style="border: 0px" /></a>
    {/if}
    {if $cat.mailimage }
    <a class="serendipity_mail_icon" {if $cat.xmlimage } style="margin-left: 1em;" {/if} href="{$cat.subscribeURL}" title="{$CONST.SUBSCRIBE_TO_TITLE|sprintf:"{$cat.category_name|escape}"}"><img src="{$cat.mailimage}" alt="Mail" style="border: 0px" /></a>
    {/if}
    </div>
    {/if}
<hr>
{/foreach}
<h2>{$CONST.ENTRIES_FOR|sprintf:"{$catlist|escape}"}:</h2>
</header>

<header class="clearfix serendipity_entry">
    <h2>{$CONST.AUTHOR}: {$author.realname|escape}</h2>
    {if $author.image || $autor.description}
    <div class='authordesc'>
    {if $author.image}<div class='authorimage'><img src="{$author.image}" alt="{$author.realname}" float="left" /></div>{/if}
    {if $author.description}<div class='authordescription'>{$author.description}</div>{/if}
    </div>
    {/if}
    {if $author.xmlimage || $author.mailimage}
    <h3>{$CONST.SUBSCRIBE}</h3>
    <div>
    {if $author.xmlimage }
    <a class="serendipity_xml_icon" href="{$author.feedURL}" title="{$CONST.FEED_OF_TITLE|sprintf:"{$author.realname|escape}"}"><img src="{$author.xmlimage}" alt="XML" style="border: 0px" /></a>
    {/if}
    {if $author.mailimage }
    <a class="serendipity_mail_icon" {if $author.xmlimage} style="margin-left: 1em;" {/if} href="{$author.subscribeURL}" title="{$CONST.SUBSCRIBE_TO_TITLE|sprintf:"{$author.realname|escape}"}"><img src="{$author.mailimage}" alt="Mail" style="border: 0px" /></a>
    {/if}
    </div>
    {/if}
<hr>
<h2>{$CONST.ENTRIES_FOR|sprintf:"{$author.realname|escape}"}:</h2>
</header>

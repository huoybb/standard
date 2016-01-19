<div class="hd">
    {{ mytag.getRelationDescription(relation)['title'] }} ({{ mytag.getRelation(relation).count() }})
    <span>{{ mytag.getRelationDescription(relation)['note'] }}</span>
</div>
{#<div class="year">#}
    {#<div class="year-list">#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026">全部</a>#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026?year=2013">2013 (3)</a>#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026?year=2012">2012 (1)</a>#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026?year=2011">2011 (1)</a>#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026?year=2009">2009 (1)</a>#}
        {#<a class="item" href="/CiteRelation/SameRef/rjdk-jyjs201012026?year=2008">2008 (3)</a>#}
    {#</div>#}
    {#<span class="lb clear">#}
        {#<span class="text">全部</span>#}
        {#<i class="icon iconfont icon-arrow-down "></i>#}
    {#</span>#}
{#</div>#}
<div class="paper-list">
    {% for item in mytag.getRelation(relation) %}
        <div class="item">
            {{ item.id }}:<a href="{{ url(['for':'tags.show','tag':item.id]) }}" target="_blank">{{ item.name }}</a>
            {%  if item.commentCount %}
                <span>评论({{ item.commentCount }})</span>
            {% endif %}
            {%  if item.attachmentCount %}
                <span>附件({{ item.attachmentCount }})</span>
            {% endif %}
            {%  if item.linkCount %}
                <span>链接({{ item.linkCount }})</span>
            {% endif %}
        </div>
    {% endfor %}
</div>
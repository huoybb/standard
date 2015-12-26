<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/filterTags.js"></script>
<div class="row">
    <h2>标签</h2>
    <div id="allTags">
        {% for mytag in auth.getMytags() %}
        <span><a href="{{ url(['for':'tags.show','tag':mytag.tags.id]) }}">{{ mytag.tags.name }}</a>({{ mytag.tagmetas.taggableCount }})</span>
        {% endfor %}
    </div>
</div>
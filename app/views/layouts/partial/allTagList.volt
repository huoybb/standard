<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/filterTags.js"></script>
<div class="row">
    <h2>标签</h2>
    <div id="allTags">
        {% for mytag in allTags.getAllTags() %}
        <span><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a>({{ mytag.taggableCount }})</span>
        {% endfor %}
    </div>
</div>
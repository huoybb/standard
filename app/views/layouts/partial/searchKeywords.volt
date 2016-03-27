<div class="row">
    <h2>最近搜索</h2>
    <div>
        {% for search in myTools.getLast5SearchedWords() %}
        <span><a href="{{ url(['for':'standards.search.index','search':search.keywords]) }}">{{ search.keywords }}</a></span>
        {% endfor %}
    </div>
</div>
<div class="row">
    <h2>最多搜索</h2>
    <div>
        {% for search in myTools.getMostSearchedWords() %}
            <span><a href="{{ url(['for':'standards.search.index','search':search.keywords]) }}">{{ search.keywords }}</a>({{ search.num }})</span>
        {% endfor %}
    </div>
</div>

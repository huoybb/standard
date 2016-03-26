<div class="row">
    <h2>最近搜索</h2>
    <ul>
        {% for search in page.lastSearchedWords %}
        <li><a href="{{ url(['for':'standards.search.index','search':search.keywords]) }}">{{ search.keywords }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="row">
    <h2>最多搜索</h2>
    <ul>
        {% for search in page.mostSearchedWords %}
            <li><a href="{{ url(['for':'standards.search.index','search':search.keywords]) }}">{{ search.keywords }}</a>({{ search.num }})</li>
        {% endfor %}
    </ul>
</div>
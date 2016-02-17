<div class="row">
    <h2>分库统计</h2>
    <ul>
        {% for data in page.statistics %}
            {% if isset(page.repository) and data['name'] is page.repository.getDBName() %}
                <li>{{ data['name'] }} ({{ data['count'] }})-<a href="{{ url(['for':'subRepository.showNoAttachment','repository':data['type']]) }}">补</a></li></li>
            {% else %}
                <li><a href="{{ url(['for':'subRepository','repository':data['type']]) }}">{{ data['name'] }}</a>
                    ({{ data['count'] }})-
                    <a href="{{ url(['for':'subRepository.showNoAttachment','repository':data['type']]) }}">补</a></li>
            {% endif %}
        {% endfor %}
    </ul>
</div>
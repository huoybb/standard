{% macro showExtraLink(data) %}
    {% if auth.role is '管理员' %}
        -<a href="{{ url(['for':'subRepository.showNoAttachment','repository':data['type']]) }}">补</a>
    {% endif %}
{% endmacro %}
<div class="row">
    <h2>分库统计</h2>
    <ul>
        {% for data in myTools.getStatistics() %}
            {% if isset(page.repository) and data['name'] is page.repository.getDBName() %}
                <li>{{ data['name'] }} ({{ data['count'] }})
                    {{ showExtraLink(data) }}
                </li>
            {% else %}
                <li><a href="{{ url(['for':'subRepository','repository':data['type']]) }}">{{ data['name'] }}</a>
                    ({{ data['count'] }})
                    {{ showExtraLink(data) }}
                </li>
            {% endif %}
        {% endfor %}
    </ul>
</div>
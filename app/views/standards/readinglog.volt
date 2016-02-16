{% extends 'index.volt' %}
{% block content %}
    <div class="container">
        <table class="table table-hover table-layout:fixed">
            <tr>
                <th>#</th>
                <th>想读</th>
                <th>在读</th>
                <th>读过</th>
            </tr>
            {% for key,record in records %}
            <tr>
                <td>{{ key }}</td>
                <td>
                    {% if isset(record['want']) %}
                        {{ record['want'].created_at }}--{{ record['want'].updated_at }}
                    {% else %}
                        --
                    {% endif %}
                </td>
                <td>
                    {% if isset(record['reading']) %}
                        {{ record['reading'].created_at }}--{{ record['reading'].updated_at }}
                    {% else %}
                        --
                    {% endif %}
                </td>
                <td>
                    {% if isset(record['done']) %}
                        {{ record['done'].created_at }}--{{ record['done'].updated_at }}
                    {% else %}
                        --
                    {% endif %}
                </td>
            </tr>
            {% endfor %}
        </table>
    </div>
{% endblock %}
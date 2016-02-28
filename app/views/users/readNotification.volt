{% extends 'index.volt' %}

{% block content %}
    <div class="container">
        {% for act in notifications %}
        <div class="row">
            用户：{{ act.act.user_id }}，在标签{{ act.act.tag_id }}下，做了{{ act.act.doing }}
        </div>
        {% endfor %}
    </div>
{% endblock %}


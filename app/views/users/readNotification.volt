{% extends 'index.volt' %}

{% block content %}
    <div class="container">
        {% for act in notifications %}
        <div class="row">
            用户：{{ act.user.name }}，在标签<a href="{{ url(['for':'tags.show','tag':act.tag.id]) }}">{{ act.tag.name }}</a>下，做了{{ act.act.doing }}
        </div>
        {% endfor %}
    </div>
{% endblock %}


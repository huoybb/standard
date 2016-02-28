{% extends 'index.volt' %}

{% block content %}
    <div class="container">
        {% for act in notifications %}
        <div class="row">
            用户：<b>{{ act.user.name }}</b>，在标签<b>{{ act.tag.name }}</b>下，做了{{ act.act.doing }}
            --<a href="{{ url(['for':'users.readNotification.done','notification':act.notify.id]) }}">阅读</a>
        </div>
        {% endfor %}
    </div>
{% endblock %}


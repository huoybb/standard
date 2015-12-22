{% extends 'tags/show.volt' %}
{% block breadcrumb %}
    <ol class="breadcrumb">
        <li><a href="{{ url.getBaseUri() }}">首页</a></li>
        <li><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">标签：{{ mytag.name }}</a></li>
        <li class="active">{{ page.month }}</li>
    </ol>
{% endblock %}
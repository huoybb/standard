{% extends 'file.volt' %}


{% block breadcrumb %}
    <ol class="breadcrumb">
        <li><a href="{{ url.getBaseUri() }}">首页</a></li>
        <li><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">标签：{{ mytag.name }}</a></li>
        <li class="active">当前文档</li>
    </ol>
{% endblock %}
{% block nav %}
    <div class="row" id="nav">
        <nav>
            <ul class="pager">
                <li class="previous"><a href="{{ url.get(['for':'tags.showItem','item':page.before,'tag':mytag.id]) }}"><span aria-hidden="true">&larr;</span> 上一个</a></li>
                <li class="next"><a href="{{ url.get(['for':'tags.showItem','item':page.next,'tag':mytag.id]) }}">下一个 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
{% endblock %}

{% extends 'file.volt' %}

{% block title %}
    标准：{{ file.title }}
{% endblock %}

{% block nav %}
    <div class="row" id="nav">
        <nav>
            <ul class="pager">
                <li class="previous"><a href="{{ url.get(['for':'standards.show','file':file.getPrevious().id]) }}"><span aria-hidden="true">&larr;</span> 上一个</a></li>
                <li class="next"><a href="{{ url.get(['for':'standards.show','file':file.getNext().id]) }}">下一个 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
{% endblock %}


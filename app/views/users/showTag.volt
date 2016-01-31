{% extends 'tags/show.volt' %}

{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_pages > 1 %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="{{ url.get(['for':'users.showTag.page','page':page.before,'tag':mytag.id,'user':user.id]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="{{ url.get(['for':'users.showTag.page','page':page.next,'tag':mytag.id,'user':user.id]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    {% endif %}
{% endblock %}
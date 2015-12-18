{% extends 'index/index.volt' %}

{% block listTitle %}
    <h1>
        月度{{ page.month }}：文档汇总<span class="badge">{{ page.total_items }}</span>
    </h1>
{% endblock %}

{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_items > page.limit %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="
                        {{ url(['for':'standards.archive.page','page':page.before,'month':page.month]) }}
                    "><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="
                        {{ url(['for':'standards.archive.page','page':page.next,'month':page.month]) }}
                    ">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    {% endif %}
{% endblock %}


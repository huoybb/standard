{% extends "index.volt" %}

{% block title %}
    标签：{{ mytag.name }}
{% endblock %}
{% block content %}


    <div class="container">
        <h1>标签：{{ mytag.name }} <span class="badge">{{ page.total_items }}</span></h1>
        {% if mytag.description %}
            <blockquote><p>{{ mytag.description }}</p></blockquote>
        {% endif %}
        <p>创建日期：{{ mytag.created_at.diffForHumans() }}</p>
        <P>操作：<a href="{{ url(['for':'tags.edit','tag':mytag.id]) }}">修改</a> <a href="{{ url(['for':'tags.delete','tag':mytag.id]) }}">删除</a></P>

        <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
        {% if page.total_pages > 1 %}
            <nav>
                <ul class="pager">
                    <li class="previous"><a href="{{ url.get(['for':'tags.show.page','page':page.before,'tag':mytag.id]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                    <li class="next"><a href="{{ url.get(['for':'tags.show.page','page':page.next,'tag':mytag.id]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>
        {% endif %}

        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>标准</th>
                <th>打签时间</th>
                <th><div align="center">操作</div></th>
            </tr>
            {% for key,item in page.items %}
                <tr>
                    <td>{{item.taggable_id}}</td>
                    <td><a title="{{ item.getTagged().title }}" href="{{ url(['for':'tags.showItem','item':key+1+page.limit*(page.current-1),'tag':item.tag_id]) }}">{{ item.getTagged().title |cut }}</a></td>
                    <td>{{ item.created_at.diffForHumans() }}</td>
                    <td><span><a href="{{ url(['for':'tags.deleteItem','taggable':item.id,'tag':mytag.id]) }}" ><div align="center">删除</div></a></span></td>
                </tr>
            {% endfor %}
        </table>
        {% include 'layouts/partial/commentListForTag.volt' %}
        {% include'layouts/partial/commentform.volt' %}


    </div>
{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}
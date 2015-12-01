{% extends "index.volt" %}

{% block title %}
    标签列表
{% endblock %}
{% block content %}


    <div class="container">
        <h1>标签列表： <span class="badge">{{ page.total_items }}</span></h1>



        <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
        {% if page.total_pages > 1 %}
            <nav>
                <ul class="pager">
                    <li class="previous"><a href="{{ url.get(['for':'tags.index.page','page':page.before]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                    <li class="next"><a href="{{ url.get(['for':'tags.index.page','page':page.next]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>
        {% endif %}

        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>标签</th>
                <th>打签数量</th>
                <th>更新时间</th>
                <th colspan="2"><div align="center">操作</div></th>
            </tr>
            {% for item in page.items %}
                <tr>
                    <td>{{item.id}}</td>
                    <td><a href="{{ url(['for':'tags.show','tag':item.id]) }}">{{ item.name }}</a></td>
                    <td>{{item.tagCounts()}}</td>
                    <td>{{ item.updated_at.diffForHumans() }}</td>
                    <td><span><a href="#" ><div align="center">修改</div></a></span></td>
                    <td><span><a href="#" ><div align="center">删除</div></a></span></td>
                </tr>
            {% endfor %}
        </table>

        {#{% include 'movies/partials/movielist3.volt' %}#}

        {#{% include 'tags/partials/commentlist.volt' %}#}

        {#{% include'tags/partials/commentform.volt' %}#}


    </div>
{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}
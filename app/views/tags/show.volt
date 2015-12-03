{% extends 'fileList.volt' %}

{% block title %}
    标签：{{ mytag.name }}
{% endblock %}
{% block listTitle %}
    <h1>标签：{{ mytag.name }} <span class="badge">{{ page.total_items }}</span></h1>
{% endblock %}
{% block listInfo %}
    {% if mytag.description %}
        <blockquote><p>{{ mytag.description }}</p></blockquote>
    {% endif %}
    <p>创建日期：{{ mytag.created_at.diffForHumans() }}</p>
    <P>操作：<a href="{{ url(['for':'tags.edit','tag':mytag.id]) }}">修改</a> <a href="{{ url(['for':'tags.delete','tag':mytag.id]) }}">删除</a></P>
{% endblock %}
{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_pages > 1 %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="{{ url.get(['for':'tags.show.page','page':page.before,'tag':mytag.id]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="{{ url.get(['for':'tags.show.page','page':page.next,'tag':mytag.id]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    {% endif %}
{% endblock %}
{% block content %}
    {{ form(url(['for':'standards.list.addTag']), "method": "post","id":"list-tag-form","class":'form-inline') }}
        <table class="table table-hover table-layout:fixed">
            <tr>
                <th><input width="2%" type="checkbox" id="fileSelect" ></th>
                <th>#</th>
                <th>标准</th>
                <th>发布时间</th>
                <th>打签时间</th>
                <th>评论</th>
                <th><div align="center">操作</div></th>
            </tr>
            {% for key,item in page.items %}
                <tr>
                    <td><input name="file_id[]" type="checkbox" value="{{ item.files.id }}" class="file_id"></td>
                    <td>{{item.files.id}}</td>
                    <td><a title="{{ item.files.title }}" href="{{ url(['for':'tags.showItem','item':key+1+page.limit*(page.current-1),'tag':mytag.id]) }}">{{ item.files.title |cut }}</a></td>
                    <td>{{ item.files.updated_at_website }}</td>
                    <td>{{ item.taggables.created_at.diffForHumans() }}</td>
                    <td>{{ item.files.getHtml('commentCount') }}</td>
                    <td><span><a href="{{ url(['for':'tags.deleteItem','taggable':item.taggables.id,'tag':mytag.id]) }}" ><div align="center">删除</div></a></span></td>
                </tr>
            {% endfor %}
        </table>
        <div class="form-group">
            <label for="tagName">标签</label>
            <input type="text" class="form-control" id="tagName" name="tagName" value="{{ search }}">
        </div>
        <button type="submit" class="btn btn-default">添加标签</button>
    {{ endform() }}
{% endblock %}

{% block comments %}
    {% include 'layouts/partial/commentListForTag.volt' %}
    {% include'layouts/partial/commentform.volt' %}
{% endblock %}

{% extends 'fileList.volt' %}
{% block title %}
    我的文档库-首页
{% endblock %}
{% block listTitle %}
    <h1>
            文档汇总<span class="badge">{{ page.total_items }}</span>
    </h1>
{% endblock %}
{% block listInfo %}
    <p>文档列表显示如下：</p>
{% endblock %}
{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_items > page.limit %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="
                    {{ url.get(['for':'index','page':page.before]) }}
                "><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="
                    {{ url.get(['for':'index','page':page.next]) }}
                ">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    {% endif %}
{% endblock %}
{% block content %}
    {{ form(url(['for':'standards.list.addTag']), "method": "post","id":"list-tag-form","class":'form-inline') }}
        <table class="table table-hover table-layout:fixed">
            <tr>
                <th><input type="checkbox" id="fileSelect" ></th>
                <th>#</th>
                <th>名称</th>
                <th>发布时间</th>
                <th>附件</th>
                <th>链接</th>
                <th>评论</th>
                <th><div align="center">操作</div></th>
            </tr>
            {% for item in page.items %}
                <tr>
                    <td><input name="file_id[]" type="checkbox" value="{{ item.id }}" class="file_id"></td>
                    <td>{{item.id}}</td>
                    <td><div class="titleCSS">
                            {% if item.type %}
                                <span class="btn-danger">{{ item.type }}</span>
                            {% endif %}
                            <a title="{{ item.title }}" href="{{ url(['for':'standards.show','file':item.id]) }}">{{ item.title }}</a>
                        </div></td>
                    <td>{{ item.updated_at_website | date }}</td>
                    <td>{{ item.getHtml('attachmentCount') }}</td>
                    <td>{{ item.getHtml('linkCount') }}</td>
                    <td>{{ item.getHtml('commentCount') }}</td>
                    <td><span><a href="{{ url(['for':'standards.edit','file':item.id]) }}" ><div align="center">修改</div></a></span></td>
                </tr>
            {% endfor %}
        </table>
    {% include "layouts/partial/fileList.commandButton.volt" %}
    {{ endform() }}
{% endblock %}
{% block sidebar %}

    {#{% cache('sidebar') %}#}
    {% include "layouts/partial/searchKeywords.volt" %}
    {% include "layouts/partial/subrepository.statistics.volt" %}
    <div class="row">
        <h2>Archives</h2>
        <ul>
            {% for data in item.getStaticsByMonth() %}
                <li><a href="{{ url(['for':'standards.archive','month':data.month]) }}">{{ data.month }}</a>  ({{ data.num }})</li>
            {% endfor %}
        </ul>
    </div>
    {% include "layouts/partial/allTagList.volt" %}
    {#{% endcache %}#}

{% endblock %}


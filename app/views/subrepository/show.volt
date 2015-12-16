{% extends 'index/index.volt' %}

{% block title %}
    {{ page.repository.getDBName() }}--我的文档库
{% endblock %}
{% block listTitle %}
    <h1>
            {{ page.repository.getDBName() }}文档汇总 <span class="badge">{{ page.total_items }}</span>
    </h1>
{% endblock %}
{% block listInfo %}
    <blockquote>
        <pre>{{ page.repository.getDBName() }}:{{ page.repository.getDBDescription() }}<br><br>网站首页:<a href="{{ page.repository.getDBHomePageLink() }}" target="_blank">链接</a></pre>
    </blockquote>
    <p>文档列表显示如下：</p>
{% endblock %}
{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_items > page.limit %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="
                    {{ url.get(['for':'subRepository.page','page':page.before,'repository':page.repository.getModelType()]) }}
                "><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="
                    {{ url.get(['for':'subRepository.page','page':page.next,'repository':page.repository.getModelType()]) }}
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
            {% for row in page.items %}
                {% set item = row.files %}
                <tr>
                    <td><input name="file_id[]" type="checkbox" value="{{ item.id }}" class="file_id"></td>
                    <td>{{item.id}}</td>
                    <td>
                        {% if row.sub.getModelType() is 'Thesis' %}
                            [{{ row.sub.degree }}]
                        {% endif %}
                        <a title="{{ item.title }}" href="{{ url(['for':'standards.show','file':item.id]) }}">{{ item.title | cut}}</a>
                    </td>
                    <td>{{ item.updated_at_website }}</td>
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

    <div class="row">
        <h2>分库统计</h2>
        <ul>
            {% for data in page.statistics %}
                <li><a href="{{ url(['for':'subRepository','repository':data['type']]) }}">{{ data['name'] }}</a> ({{ data['count'] }})</li>
            {% endfor %}
        </ul>
    </div>
    <div class="row">
        <h2>Archives</h2>
        <ul>
            {% for data in item.getStaticsByMonth() %}
                <li><a href="{{ url(['for':'standards.archive','month':data.month]) }}">{{ data.month }}</a>  ({{ data.num }})</li>
            {% endfor %}
        </ul>
    </div>
    {% include "layouts/partial/allTagList.volt" %}
{% endblock %}


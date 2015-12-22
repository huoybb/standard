{% extends 'fileList.volt' %}

{% block title %}
    标签：{{ mytag.name }}
{% endblock %}
{% block listTitle %}
    <h1>标签：{{ mytag.name }} <span class="badge">{{ page.total_items }}</span></h1>
{% endblock %}
{% block listInfo %}
    {% if mytag.description %}
        <blockquote><pre>{{ mytag.description }}</pre></blockquote>
    {% endif %}
    <p>创建日期：{{ mytag.created_at.diffForHumans() }}</p>
    <P>操作：
        <a href="{{ url(['for':'tags.edit','tag':mytag.id]) }}">修改</a>
        {% if not mytag.attachmentCount %}<a href="{{ url(['for':'tags.delete','tag':mytag.id]) }}">删除</a>{% endif %}
    </P>
    {% if mytag.attachmentCount %}
        <h2><a href="{{ url(['for':'tags.showAttachments','tag':mytag.id]) }}">学习笔记</a></h2>
        {% for attachment in mytag.attachments() %}
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td bgcolor="#FFFF33">id</td>
                    <td bgcolor="#FFFF33"><div align="center">文件下载</div></td>
                    <td bgcolor="#FFFF33"><div align="center">说明</div></td>
                    <td bgcolor="#FFFF33"><div align="center">上传时间</div></td>
                    <td bgcolor="#FFFF33">在线浏览</td>
                </tr>
                <tr>
                    <td rowspan="2"><a href="#" title="修改归属" target="_blank">{{ attachment.id }}</a></td>
                    <td><a href="{{ url.getBaseUri() }}{{ attachment.url }}" target="_blank">下载</a></td>
                    <td>{{ attachment.name }}</td>
                    <td>{{ attachment.getLastEditTime().diffForHumans() }}</td>
                    <td><a href="{{ attachment.getBaiduURL() }}" target="_blank">百度云</a></td>
                </tr>
                <tr>
                    <td colspan="3">{{ attachment.url | basename }}</td><td>{{ attachment.getFileSize() | formatSizeUnits}}</td>
                </tr>
                </tbody>
            </table>
        {% endfor %}
    {% endif %}
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
                <th>名称</th>
                <th>发布时间</th>
                <th>打签时间</th>
                <th>附件</th>
                <th>链接</th>
                <th>评论</th>
                <th><div align="center">操作</div></th>
            </tr>
            {% for key,item in page.items %}
                <tr>
                    <td><input name="file_id[]" type="checkbox" value="{{ item.files.id }}" class="file_id"></td>
                    <td>{{item.files.id}}</td>
                    <td width="400px"><a title="{{ item.files.title }}" href="{{ url(['for':'tags.showItem','item':key+1+page.limit*(page.current-1),'tag':mytag.id]) }}">{{ item.files.title |cut }}</a></td>
                    <td>{{ item.files.updated_at_website | date }}</td>
                    <td>{{ item.taggables.created_at.diffForHumans() }}</td>
                    <td>{{ item.files.getHtml('attachmentCount') }}</td>
                    <td>{{ item.files.getHtml('linkCount') }}</td>
                    <td>{{ item.files.getHtml('commentCount') }}</td>
                    <td><span><a href="{{ url(['for':'tags.deleteItem','taggable':item.taggables.id,'tag':mytag.id]) }}" ><div align="center">删除</div></a></span></td>
                </tr>
            {% endfor %}
        </table>
    {% include "layouts/partial/fileList.commandButton.volt" %}
    {{ endform() }}
{% endblock %}

{% block comments %}
    {% include 'layouts/partial/commentListForTag.volt' %}
    {% if mytag.getTaggedFileComments().count() %}
        <h2>在本标签下的评论</h2>
        <ul>
            {% for comment in mytag.getTaggedFileComments() %}
                <li>
                    <div><span>@<a href="{{ url(['for':'tags.showItem','tag':mytag.id,'item':mytag.getItemID(comment.files)]) }}">{{ comment.files.title|cut }}</a></span> <span>by <a href="#"> {{ comment.comments.user_id }}</a></span>--<span>at: {{ comment.comments.updated_at.diffForHumans() }}</span>
                        {#{% if auth.has(comment) %}#}
                        <span><a href="{{ url(['for':'standards.editComment','file':comment.files.id,'comment':comment.comments.id]) }}">edit</a></span>
                        <span><a href="{{ url(['for':'standards.deleteComment','file':comment.files.id,'comment':comment.comments.id]) }}" class="delete">delete</a></span>
                        {#{% endif %}#}
                    </div>
                    <div>
                        {{comment.comments.content|nl2br}}
                    </div>
                </li>
            {% endfor %}
        </ul>
    {% endif %}
    {% include'layouts/partial/commentform.volt' %}
{% endblock %}

{% block sidebar %}
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/tag.js"></script>
    <div class="row">
        <div class="fileUpload" id="fileUpload">
            <form action="{{ url(['for':'tags.addAttachment','tag':mytag.id]) }}" id="my-awesome-dropzone">
                心得体会上传:<br>文件拖拽到这里
            </form>
        </div>
    </div>
    <div class="row">
        <h2>Archives</h2>
        <ul>
            {% for data in mytag.getArchiveStatisticsByMonth() %}
                <li><a href="{{ url(['for':'tags.showArchive','tag':mytag.id,'month':data.month]) }}">{{ data.month }}</a>  ({{ data.num }})</li>
            {% endfor %}
        </ul>
    </div>
    {{ super() }}
{% endblock %}
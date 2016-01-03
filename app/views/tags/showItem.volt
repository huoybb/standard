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

{% block otherCommentList %}
    {% if file.getTaggableComments(mytag).count() %}
        <h2>在标签@{{ mytag.name }}下的评论</h2>
        <ul>
            {% for comment in file.getTaggableComments(mytag) %}
                <li>
                    <div> <span>by <a href="#"> {{ comment.users.name }}</a></span>--<span>at: {{ comment.comments.updated_at.diffForHumans() }}</span>
                        {#{% if auth.has(comment) %}#}
                        <span><a href="{{ url(['for':'standards.editComment','file':file.id,'comment':comment.comments.id]) }}">edit</a></span>
                        <span><a href="{{ url(['for':'standards.deleteComment','file':file.id,'comment':comment.comments.id]) }}" class="delete">delete</a></span>
                        {#{% endif %}#}
                    </div>
                    <div>
                        {{comment.comments.content|nl2br}}
                    </div>
                </li>
            {% endfor %}
        </ul>
    {% endif %}
{% endblock %}

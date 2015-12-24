{% extends 'file.volt' %}

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

{% block otherCommentList %}
    {% if file.getTaggableComments().count() %}
        <h2>在标签下的评论</h2>
        <ul>
            {% for comment in file.getTaggableComments() %}
                <li>
                    <div> <span>@<a href="{{ url(['for':'tags.show','tag':comment.tags.id]) }}">{{ comment.tags.name }}</a></span><span>by <a href="#"> {{ comment.users.name }}</a></span>--<span>at: {{ comment.comments.updated_at.diffForHumans() }}</span>
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


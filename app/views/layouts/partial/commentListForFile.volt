<hr>

<h2>Comments:</h2>
{% if file.hasComments() %}
<ul>
    {% for comment in file.comments() %}
    <li>
        <div> <span>by <a href="#"> {{ comment.user_id }}</a></span>--<span>at: {{ comment.updated_at.diffForHumans() }}</span>
            {#{% if auth.has(comment) %}#}
            <span><a href="{{ url(['for':'standards.editComment','file':file.id,'comment':comment.id]) }}">edit</a></span>
            <span><a href="{{ url(['for':'standards.deleteComment','file':file.id,'comment':comment.id]) }}" class="delete">delete</a></span>
            {#{% endif %}#}
        </div>
        <div>
            {{comment.content|nl2br}}
        </div>
    </li>
    {% endfor %}
</ul>
{% endif %}
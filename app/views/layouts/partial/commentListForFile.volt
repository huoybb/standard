<hr>

<h2>Comments:</h2>
{% if file.hasComments() %}
<ul>
    {% for comment in file.comments() %}
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
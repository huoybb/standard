<hr>

<h2>Comments:</h2>
<ul>
    {% for comment in mytag.comments() %}
    <li>
        <div> <span>by <a href="#"> {{ comment.users.name }}</a></span>--<span>at: {{ comment.comments.updated_at.diffForHumans() }}</span>
            {#{% if auth.has(comment) %}#}
            <span><a href="{{ url(['for':'tags.editComment','tag':mytag.id,'comment':comment.comments.id]) }}">edit</a></span>
            <span><a href="{{ url(['for':'tags.deleteComment','tag':mytag.id,'comment':comment.comments.id]) }}">delete</a></span>
            {#{% endif %}#}
        </div>
        <div>
            {{comment.comments.content|nl2br}}
        </div>
    </li>
    {% endfor %}
</ul>
{% extends 'index.volt' %}

{% block content %}
    <div class="container">

        <table class="table table-striped">
        {% for act in notifications %}
            <tr>
                <td>{{ act.act.updated_at.diffForHumans() }}，<b>{{ act.user.name }}</b>，在标签<b>{{ act.tag.name }}</b>下，做了 <b>{{ act.act.showDoing() }}</b>
                    --
                    {% if act.notify.status %}
                        <a href="{{ url(['for':'tags.show','tag':act.tag.id]) }}">看过</a>
                    {% else %}
                        <a href="{{ url(['for':'users.readNotification.done','notification':act.notify.id]) }}">查看</a>
                    {% endif %}
                </td>
            </tr>

        {% endfor %}
        </table>
    </div>
{% endblock %}


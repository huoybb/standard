{% extends "index.volt" %}
{% block title %}
    修改：{{ mytag.name }}
{% endblock %}

{% block content %}
    {% include 'layouts/partial/edit.volt' %}
{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}
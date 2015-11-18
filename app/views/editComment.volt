{{ content() }}
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="{{ url.getBaseUri() }}css/app.css">
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/jquery-2.1.4.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/keymaster.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/my.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.edit.js"></script>
</head>
<body>
{% include "layouts/header.volt" %}
{% block content %}
    <div class="container">
        <p>{{ flash.output() }}</p>
        {{ form("method": "post",'id':'edit') }}

        <div class="form-group">
            conent:{{ form.render('content',['class':'form-control','rows':6]) }}<br/>
        </div>


        <div class="form-group">
            {{ form.render('修改',['class':'btn btn-primary form-control']) }}
        </div>
        {{ endform() }}

    </div>

{% endblock %}
{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}
</body>
</html>

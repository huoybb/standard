{{ content() }}
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="{{ url.getBaseUri() }}css/app.css">
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/jquery-2.1.4.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/keymaster.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/dropzone.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/my.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/maniputateFileList.js"></script>
</head>
<body>
    {% include "layouts/header.volt" %}
    <div class="container">
        {% block breadcrumb %}{% endblock %}
        {% block listTitle %}{% endblock %}
        <div class="row">
            <div class="col-md-10">
                {% block listInfo %}{% endblock %}
                {% block nav %}{% endblock %}
                {% block content %}{% endblock %}
                {% block comments %}{% endblock %}
            </div>
            <div class="col-md-2">
                {% block sidebar %}
                    {% include "layouts/partial/allTagList.volt" %}
                {% endblock %}
            </div>
        </div>
    </div>
    {% block footer %}
        <div class="container">
            <div class="row">
                <?php echo xdebug_time_index();?>
            </div>
        </div>
    {% endblock %}
</body>
</html>
{{ content() }}
<!DOCTYPE html>
<html>
	<head>
		<title>{% block title %}{% endblock %}</title>
        <link rel="stylesheet" href="{{ url.getBaseUri() }}css/app.css">
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/jquery-2.1.4.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/keymaster.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/my.js"></script>
	</head>
	<body>
        {% include "layouts/header.volt" %}
        {% block content %}{% endblock %}
        {% block footer %}
            <div class="container">
                <div class="row">
                    <?php echo xdebug_time_index();?>
                </div>
            </div>
        {% endblock %}
    </body>
</html>

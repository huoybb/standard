<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ myTools.getSiteName() }}</a>
        </div>
        {% if session.has('auth') %}
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            {{ startMeasure('s1-1','布局链接数组') }}
            <ul class="nav navbar-nav">

                {% for key,value in myTools.getLayoutLinkArray() %}
                <li><a href="{{ url.getBaseUri() }}{{key}}">{{value}}</a></li>
                {% endfor %}

            </ul>
            {{ stopMeasure('s1-1') }}

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form id="search-form" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <?php $search = isset($search) ?$search: null?>
                            {{ text_field("search",'class':'form-control','placeholder':'Search','value':search) }}
                        </div>
                        <button type="submit" class="btn btn-default">查询</button>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li><a href="{{ url(['for':'logout']) }}">logout</a></li>
                {% if auth.role is '管理员' %}
                <li><a href="{{ url(['for':'users.manageUsers']) }}">用户管理</a></li>
                {% endif %}
            </ul>
        </div>
        {% endif %}
    </div>
</nav>
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">赵兵的文档库</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                {% for key,value in ['standards/add':'新增','tags':'标签'] %}
                <li><a href="{{ url.getBaseUri() }}{{key}}">{{value}}</a></li>
                {% endfor %}

            </ul>

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
        </div>
    </div>
</nav>
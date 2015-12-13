{% if file.hasRelations() %}
    <h2>引文系统</h2>
    <div class="citeRelation clear" data-id="{{ file.id }}" style="display: block;">
        <div class="refciteMap">
            <div class="map-item cite cite1">
                <div class="tt">{{ file.getRelationDescription('cite1')['title'] }}</div>
                <div class="count">({{ file.getCitations().count() }})</div>
            </div>
            <div class="map-item cite cite2">
                <div class="tt">{{ file.getRelationDescription('cite2')['title'] }}</div>
                <div class="count">({{ file.getSecondCitations().count() }})</div>
            </div>
            <div class="map-item ref ref1">
                <div class="tt">{{ file.getRelationDescription('ref1')['title'] }}</div>
                <div class="count">({{ file.getReferences().count() }})</div>
            </div>
            <div class="map-item ref ref2">
                <div class="tt">{{ file.getRelationDescription('ref2')['title'] }}</div>
                <div class="count">({{ file.getSecondReferences().count() }})</div>
            </div>
            <div class="map-item same cite sameCite">
                <div class="tt">{{ file.getRelationDescription('sameCite')['title'] }}</div>
                <div class="count">({{ file.getSameCitations().count() }})</div>
            </div>
            <div class="map-item same ref sameRef">
                <div class="tt">{{ file.getRelationDescription('sameRef')['title'] }}</div>
                <div class="count">({{ file.getSameReferences().count() }})</div>
            </div>
            <div class="map-item text">
                <div class="tt">本文</div>
            </div>
            <div id="markLine"></div>
        </div>
        <div class="papers">
        </div>
    </div>
{% endif %}
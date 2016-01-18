{% if mytag.hasRelations() %}
    <h2>引文系统</h2>
    <div class="citeRelation clear" data-id="{{ mytag.id }}" style="display: block;">
        <div class="refciteMap">
            <div class="map-item cite cite1">
                <div class="tt">{{ mytag.getRelationDescription('cite1')['title'] }}</div>
                <div class="count">({{ mytag.getCitations().count() }})</div>
            </div>
            <div class="map-item cite cite2">
                <div class="tt">{{ mytag.getRelationDescription('cite2')['title'] }}</div>
                <div class="count">({{ mytag.getSecondCitations().count() }})</div>
            </div>
            <div class="map-item ref ref1">
                <div class="tt">{{ mytag.getRelationDescription('ref1')['title'] }}</div>
                <div class="count">({{ mytag.getReferences().count() }})</div>
            </div>
            <div class="map-item ref ref2">
                <div class="tt">{{ mytag.getRelationDescription('ref2')['title'] }}</div>
                <div class="count">({{ mytag.getSecondReferences().count() }})</div>
            </div>
            <div class="map-item same cite sameCite">
                <div class="tt">{{ mytag.getRelationDescription('sameCite')['title'] }}</div>
                <div class="count">({{ mytag.getSameCitations().count() }})</div>
            </div>
            <div class="map-item same ref sameRef">
                <div class="tt">{{ mytag.getRelationDescription('sameRef')['title'] }}</div>
                <div class="count">({{ mytag.getSameReferences().count() }})</div>
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
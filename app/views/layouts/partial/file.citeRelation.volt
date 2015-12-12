<div class="citeRelation clear" data-url="/CiteRelation/Map" data-id="{{ file.id }}" style="display: block;"><div class="refciteMap">
        <div class="map-item cite cite1" data-url="/CiteRelation/Cite" data-mark="mark-cite1">
            <div class="tt">{{ file.getRelationDescription('cite1')['title'] }}</div>
            <div class="count">({{ file.getCitations().count() }})</div>
        </div>
        <div class="map-item cite cite2" data-url="/CiteRelation/Cite2" data-mark="mark-cite2">
            <div class="tt">{{ file.getRelationDescription('cite2')['title'] }}</div>
            <div class="count">({{ file.getSecondCitations().count() }})</div>
        </div>
        <div class="map-item ref ref1" data-url="/CiteRelation/Ref" data-mark="mark-ref1">
            <div class="tt">{{ file.getRelationDescription('ref1')['title'] }}</div>
            <div class="count">({{ file.getReferences().count() }})</div>
        </div>
        <div class="map-item ref ref2" data-url="/CiteRelation/Ref2" data-mark="mark-ref2">
            <div class="tt">{{ file.getRelationDescription('ref2')['title'] }}</div>
            <div class="count">({{ file.getSecondReferences().count() }})</div>
        </div>
        <div class="map-item same cite sameCite" data-url="/CiteRelation/SameCite" data-mark="mark-sameCite">
            <div class="tt">{{ file.getRelationDescription('sameCite')['title'] }}</div>
            <div class="count">({{ file.getSameCitations().count() }})</div>
        </div>
        <div class="map-item same ref sameRef" data-url="/CiteRelation/SameRef" data-mark="mark-sameRef">
            <div class="tt">{{ file.getRelationDescription('sameRef')['title'] }}</div>
            <div class="count">({{ file.getSameReferences().count() }})</div>
        </div>
        <div class="map-item text" data-mark="mark-mtext">
            <div class="tt">本文</div>
        </div>
        <div id="markLine"></div>
    </div>
    <div class="papers">
    </div>
</div>
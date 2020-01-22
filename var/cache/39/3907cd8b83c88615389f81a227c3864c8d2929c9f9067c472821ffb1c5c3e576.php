<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Map.html.twig */
class __TwigTemplate_35d9d07743432077c7c98b60c181a3085c1d0e52f2c0f80bca2e69456161be6a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "index.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("index.html.twig", "Map.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->displayParentBlock("title", $context, $blocks);
        echo " - Carte ";
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "<main>
<div id='map' style='width: 1920px; height: 1000px; border-radius: 20px;'></div>
<script>
\tmapboxgl.accessToken = 'pk.eyJ1IjoiYWxleGFuZHJldmVzaWVyIiwiYSI6ImNrNGI0Z29tYjBhODAzaW14d29xcnkxMHgifQ.zp68F8Jk2H2K6pjr0O4yWA';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v9'
});
 
var size = 200;
 
// implementation of CustomLayerInterface to draw a pulsing dot icon on the map
// see https://docs.mapbox.com/mapbox-gl-js/api/#customlayerinterface for more info
var pulsingDot = {
width: size,
height: size,
data: new Uint8Array(size * size * 4),
 
// get rendering context for the map canvas when layer is added to the map
onAdd: function() {
var canvas = document.createElement('canvas');
canvas.width = this.width;
canvas.height = this.height;
this.context = canvas.getContext('2d');
},
 
// called once before every frame where the icon will be used
render: function() {
var duration = 1000;
var t = (performance.now() % duration) / duration;
 
var radius = (size / 2) * 0.3;
var outerRadius = (size / 2) * 0.7 * t + radius;
var context = this.context;
 
// draw outer circle
context.clearRect(0, 0, this.width, this.height);
context.beginPath();
context.arc(
this.width / 2,
this.height / 2,
outerRadius,
0,
Math.PI * 2
);
context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
context.fill();
 
// draw inner circle
context.beginPath();
context.arc(
this.width / 2,
this.height / 2,
radius,
0,
Math.PI * 2
);
context.fillStyle = 'rgba(255, 100, 100, 1)';
context.strokeStyle = 'white';
context.lineWidth = 2 + 4 * (1 - t);
context.fill();
context.stroke();
 
// update this image's data with data from the canvas
this.data = context.getImageData(
0,
0,
this.width,
this.height
).data;
 
// continuously repaint the map, resulting in the smooth animation of the dot
map.triggerRepaint();
 
// return `true` to let the map know that the image was updated
return true;
}
};
 
map.on('load', function() {
map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 2 });
 
map.addLayer({
'id': 'points',
'type': 'symbol',
'source': {
'type': 'geojson',
'data': {
'type': 'FeatureCollection',
'features': [
{
'type': 'Feature',
'geometry': {
'type': 'Point',
'coordinates': [1.1047, 49.3779]
}
}
]
}
},
'layout': {
'icon-image': 'pulsing-dot'
}
});
});
</script>
</main>
";
    }

    public function getTemplateName()
    {
        return "Map.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 4,  55 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"index.html.twig\" %}
{% block title %}{{ parent() }} - Carte {% endblock %}
{% block body %}
<main>
<div id='map' style='width: 1920px; height: 1000px; border-radius: 20px;'></div>
<script>
\tmapboxgl.accessToken = 'pk.eyJ1IjoiYWxleGFuZHJldmVzaWVyIiwiYSI6ImNrNGI0Z29tYjBhODAzaW14d29xcnkxMHgifQ.zp68F8Jk2H2K6pjr0O4yWA';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v9'
});
 
var size = 200;
 
// implementation of CustomLayerInterface to draw a pulsing dot icon on the map
// see https://docs.mapbox.com/mapbox-gl-js/api/#customlayerinterface for more info
var pulsingDot = {
width: size,
height: size,
data: new Uint8Array(size * size * 4),
 
// get rendering context for the map canvas when layer is added to the map
onAdd: function() {
var canvas = document.createElement('canvas');
canvas.width = this.width;
canvas.height = this.height;
this.context = canvas.getContext('2d');
},
 
// called once before every frame where the icon will be used
render: function() {
var duration = 1000;
var t = (performance.now() % duration) / duration;
 
var radius = (size / 2) * 0.3;
var outerRadius = (size / 2) * 0.7 * t + radius;
var context = this.context;
 
// draw outer circle
context.clearRect(0, 0, this.width, this.height);
context.beginPath();
context.arc(
this.width / 2,
this.height / 2,
outerRadius,
0,
Math.PI * 2
);
context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
context.fill();
 
// draw inner circle
context.beginPath();
context.arc(
this.width / 2,
this.height / 2,
radius,
0,
Math.PI * 2
);
context.fillStyle = 'rgba(255, 100, 100, 1)';
context.strokeStyle = 'white';
context.lineWidth = 2 + 4 * (1 - t);
context.fill();
context.stroke();
 
// update this image's data with data from the canvas
this.data = context.getImageData(
0,
0,
this.width,
this.height
).data;
 
// continuously repaint the map, resulting in the smooth animation of the dot
map.triggerRepaint();
 
// return `true` to let the map know that the image was updated
return true;
}
};
 
map.on('load', function() {
map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 2 });
 
map.addLayer({
'id': 'points',
'type': 'symbol',
'source': {
'type': 'geojson',
'data': {
'type': 'FeatureCollection',
'features': [
{
'type': 'Feature',
'geometry': {
'type': 'Point',
'coordinates': [1.1047, 49.3779]
}
}
]
}
},
'layout': {
'icon-image': 'pulsing-dot'
}
});
});
</script>
</main>
{% endblock %}
", "Map.html.twig", "C:\\Users\\mfleu\\OneDrive\\Documents\\Projet\\rencontre\\templates\\Map.html.twig");
    }
}

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

/* index.html.twig */
class __TwigTemplate_19335565a47056d217480548d9c7e5fb854a2fd88c7b5389a23d034cd9c40524 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/pepper-grinder/jquery-ui.css\">
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.8.1/css/all.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css\">
    <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.5.1/dist/leaflet.css\" integrity=\"sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==\" crossorigin=\"\"/>
    <script src=\"https://api.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js\"></script>
    <link rel=\"stylesheet\" href=\"/css/style.css\">

<body>

<nav class=\"navbar sticky-top nav-pills navbar-expand-lg navbar-light bg-light\">

    <a class=\"navbar-brand\" href=\"#\">
        <img src=\"./doc/fym.svg\" width=\"30\" height=\"30\" class=\"d-inline-block align-top\" alt=\"\">
        Find My Mate
    </a>
    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarTogglerDemo02\" aria-controls=\"navbarTogglerDemo02\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
    </button>
    <div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo02\">
        <!--<div class=\"row\">-->

        <ul class=\"nav navbar-nav ml-md--auto\">

            <li class=\"dropdown\">

                <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"navbarDropdown\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                    Welcome, User <b class=\"caret\"></b>
                </a>

                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                    <a class=\"dropdown-item\" href=\"#\">Action</a>
                    <a class=\"dropdown-item\" href=\"#\">Another action</a>
                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item\" href=\"#\">Something else here</a>
                </div>

            </li>
        </ul>



        <form class=\"form-inline\" method=\"post\" action=\"/Utilisateur/Show/";
        // line 48
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "search", [], "any", false, false, false, 48), "html", null, true);
        echo "\">
            <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Rechercher\" name=\"search\">
            <input type=\"submit\" class=\"btn btn-outline-success my-2 my-sm-0\" value=\"Rechercher\" name=\"searchSubmit\">
        </form>
    </div>

</nav>

";
        // line 56
        $this->displayBlock('body', $context, $blocks);
        // line 57
        echo "


<script src=\"https://code.jquery.com/jquery-3.4.0.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\"></script>
<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js\"></script>

</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Find My Mate";
    }

    // line 56
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 56,  120 => 5,  104 => 57,  102 => 56,  91 => 48,  45 => 5,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <title>{% block title %}Find My Mate{% endblock %}</title>
    <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/pepper-grinder/jquery-ui.css\">
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.8.1/css/all.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css\">
    <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.5.1/dist/leaflet.css\" integrity=\"sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==\" crossorigin=\"\"/>
    <script src=\"https://api.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js\"></script>
    <link rel=\"stylesheet\" href=\"/css/style.css\">

<body>

<nav class=\"navbar sticky-top nav-pills navbar-expand-lg navbar-light bg-light\">

    <a class=\"navbar-brand\" href=\"#\">
        <img src=\"./doc/fym.svg\" width=\"30\" height=\"30\" class=\"d-inline-block align-top\" alt=\"\">
        Find My Mate
    </a>
    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarTogglerDemo02\" aria-controls=\"navbarTogglerDemo02\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
    </button>
    <div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo02\">
        <!--<div class=\"row\">-->

        <ul class=\"nav navbar-nav ml-md--auto\">

            <li class=\"dropdown\">

                <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"navbarDropdown\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                    Welcome, User <b class=\"caret\"></b>
                </a>

                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                    <a class=\"dropdown-item\" href=\"#\">Action</a>
                    <a class=\"dropdown-item\" href=\"#\">Another action</a>
                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item\" href=\"#\">Something else here</a>
                </div>

            </li>
        </ul>



        <form class=\"form-inline\" method=\"post\" action=\"/Utilisateur/Show/{{ post.search }}\">
            <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Rechercher\" name=\"search\">
            <input type=\"submit\" class=\"btn btn-outline-success my-2 my-sm-0\" value=\"Rechercher\" name=\"searchSubmit\">
        </form>
    </div>

</nav>

{% block body %}{% endblock %}



<script src=\"https://code.jquery.com/jquery-3.4.0.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\"></script>
<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js\"></script>

</body>
</html>
", "index.html.twig", "C:\\Users\\mfleu\\OneDrive\\Documents\\Projet\\rencontre\\templates\\index.html.twig");
    }
}

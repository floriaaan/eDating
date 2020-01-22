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
    <link rel=\"stylesheet\" href=\"/css/map.css\">
    <link rel=\"stylesheet\" href=\"/css/fmm.css\">

<body>

<nav class=\"navbar sticky-top nav-pills navbar-expand-lg navbar-light bg-light\">

    <a class=\"navbar-brand\" href=\"";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["server"] ?? null), "document_root", [], "any", false, false, false, 19), "html", null, true);
        echo "/index.php\">
        <img src=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["server"] ?? null), "document_root", [], "any", false, false, false, 20), "html", null, true);
        echo "/doc/fmm.svg\" width=\"30\" height=\"30\" class=\"d-inline-block align-top\" alt=\"Find My Mate\">
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

                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#register\">Se créer un compte</a>
                    <a class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#login\">Se connecter</a>
                </div>

            </li>
        </ul>



        <form class=\"form-inline\" method=\"post\" action=\"/Utilisateur/Mate/\">
            <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Rechercher\" name=\"search\">
            <input type=\"submit\" class=\"btn btn-outline-success my-2 my-sm-0\" value=\"Rechercher\">
        </form>
    </div>

</nav>

";
        // line 58
        $this->displayBlock('body', $context, $blocks);
        // line 59
        echo "
<div class=\"modal fade\" id=\"login\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Se connecter</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <form method=\"post\" action=\"./traitement.php\">
                <div class=\"modal-body\">
                    <div class=\"form-group\">
                        <label for=\"loginEmail\">Adresse mail</label>
                        <input type=\"email\" class=\"form-control\" id=\"loginEmail\" name=\"loginEmail\" aria-describedby=\"loginHelpEmail\" placeholder=\"Entrez votre adresse mail\" required>
                        <small id=\"loginHelpEmail\" class=\"form-text text-muted\">Nous ne partagerons pas vos données personnelles promis &#128521;</small>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"loginPassword\">Mot de passe</label>
                        <input type=\"password\" class=\"form-control\" id=\"loginPassword\" name=\"loginPassword\" placeholder=\"Entrez votre mot de passe\" required>
                    </div>
                    <div class=\"custom-control custom-checkbox my-1 mr-sm-2\">
                        <input type=\"checkbox\" class=\"custom-control-input\" name=\"loginCheckRemember\" id=\"loginCheckRemember\">
                        <label class=\"custom-control-label\" for=\"loginCheckRemember\">Se souvenir de moi</label>
                    </div>
                </div>

                <div class=\"modal-footer\">
                    <input type=\"hidden\" name=\"origin\" value=\"login\"/>
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Fermer</button>
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"Se connecter\"/>
                </div>
            </form>

        </div>
    </div>
</div>






<div class=\"modal fade\" id=\"register\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Se créer un compte</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <form method=\"post\" action=\"./traitement.php\">
                <div class=\"modal-body\">

                    <div class=\"form-group form-row\">

                        <div class=\"col\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Prénom\" name=\"\">
                        </div>
                        <div class=\"col\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Nom\">
                        </div>

                    </div>


                    <div class=\"form-group\">
                        <label for=\"loginEmail\">Adresse mail</label>
                        <input type=\"email\" class=\"form-control\" id=\"loginEmail\" name=\"loginEmail\" aria-describedby=\"loginHelpEmail\" placeholder=\"Entrez votre adresse mail\" required>
                        <small id=\"loginHelpEmail\" class=\"form-text text-muted\">Nous ne partagerons pas vos données personnelles promis &#128521;</small>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"loginPassword\">Mot de passe</label>
                        <input type=\"password\" class=\"form-control\" id=\"loginPassword\" name=\"loginPassword\" placeholder=\"Entrez votre mot de passe\" required>
                    </div>
                    <div class=\"custom-control custom-checkbox my-1 mr-sm-2\">
                        <input type=\"checkbox\" class=\"custom-control-input\" name=\"loginCheckRemember\" id=\"loginCheckRemember\">
                        <label class=\"custom-control-label\" for=\"loginCheckRemember\">Se souvenir de moi</label>
                    </div>
                </div>

                <div class=\"modal-footer\">
                    <input type=\"hidden\" name=\"origin\" value=\"register\"/>
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Fermer</button>
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"Se créer un compte\"/>
                </div>
            </form>

        </div>
    </div>
</div>

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

    // line 58
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
        return array (  222 => 58,  215 => 5,  109 => 59,  107 => 58,  66 => 20,  62 => 19,  45 => 5,  39 => 1,);
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
    <link rel=\"stylesheet\" href=\"/css/map.css\">
    <link rel=\"stylesheet\" href=\"/css/fmm.css\">

<body>

<nav class=\"navbar sticky-top nav-pills navbar-expand-lg navbar-light bg-light\">

    <a class=\"navbar-brand\" href=\"{{ server.document_root }}/index.php\">
        <img src=\"{{ server.document_root }}/doc/fmm.svg\" width=\"30\" height=\"30\" class=\"d-inline-block align-top\" alt=\"Find My Mate\">
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

                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#register\">Se créer un compte</a>
                    <a class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#login\">Se connecter</a>
                </div>

            </li>
        </ul>



        <form class=\"form-inline\" method=\"post\" action=\"/Utilisateur/Mate/\">
            <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Rechercher\" name=\"search\">
            <input type=\"submit\" class=\"btn btn-outline-success my-2 my-sm-0\" value=\"Rechercher\">
        </form>
    </div>

</nav>

{% block body %}{% endblock %}

<div class=\"modal fade\" id=\"login\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Se connecter</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <form method=\"post\" action=\"./traitement.php\">
                <div class=\"modal-body\">
                    <div class=\"form-group\">
                        <label for=\"loginEmail\">Adresse mail</label>
                        <input type=\"email\" class=\"form-control\" id=\"loginEmail\" name=\"loginEmail\" aria-describedby=\"loginHelpEmail\" placeholder=\"Entrez votre adresse mail\" required>
                        <small id=\"loginHelpEmail\" class=\"form-text text-muted\">Nous ne partagerons pas vos données personnelles promis &#128521;</small>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"loginPassword\">Mot de passe</label>
                        <input type=\"password\" class=\"form-control\" id=\"loginPassword\" name=\"loginPassword\" placeholder=\"Entrez votre mot de passe\" required>
                    </div>
                    <div class=\"custom-control custom-checkbox my-1 mr-sm-2\">
                        <input type=\"checkbox\" class=\"custom-control-input\" name=\"loginCheckRemember\" id=\"loginCheckRemember\">
                        <label class=\"custom-control-label\" for=\"loginCheckRemember\">Se souvenir de moi</label>
                    </div>
                </div>

                <div class=\"modal-footer\">
                    <input type=\"hidden\" name=\"origin\" value=\"login\"/>
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Fermer</button>
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"Se connecter\"/>
                </div>
            </form>

        </div>
    </div>
</div>






<div class=\"modal fade\" id=\"register\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Se créer un compte</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <form method=\"post\" action=\"./traitement.php\">
                <div class=\"modal-body\">

                    <div class=\"form-group form-row\">

                        <div class=\"col\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Prénom\" name=\"\">
                        </div>
                        <div class=\"col\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Nom\">
                        </div>

                    </div>


                    <div class=\"form-group\">
                        <label for=\"loginEmail\">Adresse mail</label>
                        <input type=\"email\" class=\"form-control\" id=\"loginEmail\" name=\"loginEmail\" aria-describedby=\"loginHelpEmail\" placeholder=\"Entrez votre adresse mail\" required>
                        <small id=\"loginHelpEmail\" class=\"form-text text-muted\">Nous ne partagerons pas vos données personnelles promis &#128521;</small>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"loginPassword\">Mot de passe</label>
                        <input type=\"password\" class=\"form-control\" id=\"loginPassword\" name=\"loginPassword\" placeholder=\"Entrez votre mot de passe\" required>
                    </div>
                    <div class=\"custom-control custom-checkbox my-1 mr-sm-2\">
                        <input type=\"checkbox\" class=\"custom-control-input\" name=\"loginCheckRemember\" id=\"loginCheckRemember\">
                        <label class=\"custom-control-label\" for=\"loginCheckRemember\">Se souvenir de moi</label>
                    </div>
                </div>

                <div class=\"modal-footer\">
                    <input type=\"hidden\" name=\"origin\" value=\"register\"/>
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Fermer</button>
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"Se créer un compte\"/>
                </div>
            </form>

        </div>
    </div>
</div>

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

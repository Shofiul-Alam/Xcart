<?php

/* modules/QSL/CloudSearch/cloud_filters/placeholder.twig */
class __TwigTemplate_cccfcc536d3cdb81be7539e168c3c347c41a6de20cae1de83b523249985258ba extends \XLite\Core\Templating\Twig\Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "
";
        // line 3
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "placeholderValue", array()), "html", null, true);
    }

    public function getTemplateName()
    {
        return "modules/QSL/CloudSearch/cloud_filters/placeholder.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 3,  19 => 2,);
    }
}
/* {# A special marker to designate that the actual FiltersBox widget content should be substituted later #}*/
/* */
/* {{ this.placeholderValue }}*/

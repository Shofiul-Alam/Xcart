<?php

/* header/parts/base.twig */
class __TwigTemplate_3051f3cf8a6ecdcb1a7ca46911808dd628bb14a24d4f5aa183ec7c467fa34801 extends \XLite\Core\Templating\Twig\Template
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
        // line 6
        echo "
<base href=\"";
        // line 7
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getBaseShopURL", array(), "method"), "html", null, true);
        echo "\" />
";
    }

    public function getTemplateName()
    {
        return "header/parts/base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # "Base" tag*/
/*  #*/
/*  # @ListChild (list="head", weight="1")*/
/*  #}*/
/* */
/* <base href="{{ this.getBaseShopURL() }}" />*/
/* */

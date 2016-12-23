<?php

/* layout/header/header.right.settings.twig */
class __TwigTemplate_6ec98a5057641d34179ab1b5e795c6a781666b506044f0ca0987893f49b2a5d3 extends \XLite\Core\Templating\Twig\Template
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
        // line 5
        echo "
<div class=\"header_settings dropdown ";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getHeaderSettingsClasses", array(), "method"), "html", null, true);
        echo "\" title=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Menu")), "html", null, true);
        echo "\">
    <a data-target=\"#\" data-toggle=\"dropdown\"></a>
    <div class=\"dropdown-menu\">
        ";
        // line 9
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "layout.header.right.settings"))), "html", null, true);
        echo "
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "layout/header/header.right.settings.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 9,  22 => 6,  19 => 5,);
    }
}
/* {##*/
/*  # Header right settings*/
/*  #*/
/*  #}*/
/* */
/* <div class="header_settings dropdown {{ this.getHeaderSettingsClasses() }}" title="{{ t('Menu') }}">*/
/*     <a data-target="#" data-toggle="dropdown"></a>*/
/*     <div class="dropdown-menu">*/
/*         {{ widget_list('layout.header.right.settings') }}*/
/*     </div>*/
/* </div>*/
/* */

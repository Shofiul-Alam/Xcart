<?php

/* layout/content/center_top.twig */
class __TwigTemplate_2e6f9c01a919939517fcb8123b3f37f362ba32e1b4d0915ba6f90db09c255900 extends \XLite\Core\Templating\Twig\Template
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
        // line 4
        echo "
";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "center"))), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "layout/content/center_top.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Center widgets switcher*/
/*  #}*/
/* */
/* {{ widget_list('center') }}*/
/* */

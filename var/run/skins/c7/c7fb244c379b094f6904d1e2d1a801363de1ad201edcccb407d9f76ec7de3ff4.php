<?php

/* layout/header/header.right.search.twig */
class __TwigTemplate_c0e11ed26f6c7b3fff77f1bfb12f6dda39646609799e47ed7c1ed23445b8b25e extends \XLite\Core\Templating\Twig\Template
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
        // line 7
        echo "
<div class=\"header_search\" title=\"";
        // line 8
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Search")), "html", null, true);
        echo "\">
  <a data-target=\".header_search-panel\" data-toggle=\"collapse\" class=\"collapsed\"></a>
  <div class=\"header_search-panel collapse\">
    ";
        // line 11
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Form\\Product\\Search\\Customer\\Simple"))), "html", null, true);
        echo "
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "layout/header/header.right.search.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 11,  22 => 8,  19 => 7,);
    }
}
/* {##*/
/*  # Header bar search box*/
/*  #*/
/*  # @ListChild (list="layout.header.right", weight="10")*/
/*  # @ListChild (list="layout.header.right.mobile", weight="10")*/
/*  #}*/
/* */
/* <div class="header_search" title="{{ t('Search') }}">*/
/*   <a data-target=".header_search-panel" data-toggle="collapse" class="collapsed"></a>*/
/*   <div class="header_search-panel collapse">*/
/*     {{ widget('\\XLite\\View\\Form\\Product\\Search\\Customer\\Simple') }}*/
/*   </div>*/
/* </div>*/
/* */

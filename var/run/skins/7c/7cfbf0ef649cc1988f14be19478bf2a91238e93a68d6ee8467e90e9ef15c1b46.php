<?php

/* layout/content/main.center.right.twig */
class __TwigTemplate_0dd7d185a2157e925f18218b86e049e0639f6a3a57bd72daa8665b154327988c extends \XLite\Core\Templating\Twig\Template
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
";
        // line 7
        if ($this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "layout", array()), "isSidebarSecondVisible", array(), "method")) {
            // line 8
            echo "  <div id=\"sidebar-second\" class=\"column sidebar\">
    <div class=\"section\">
      ";
            // line 10
            if ($this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "layout", array()), "isSidebarSingle", array(), "method")) {
                // line 11
                echo "      \t";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\View\\ListContainer", "innerList" => "sidebar.single", "group" => "sidebar"))), "html", null, true);
                echo "
      ";
            } else {
                // line 13
                echo "      \t";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\View\\ListContainer", "innerList" => "sidebar.second", "group" => "sidebar"))), "html", null, true);
                echo "
      ";
            }
            // line 15
            echo "    </div>
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "layout/content/main.center.right.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 15,  36 => 13,  30 => 11,  28 => 10,  24 => 8,  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Right sidebar*/
/*  #*/
/*  # @ListChild (list="layout.main.center", weight="300")*/
/*  #}*/
/* */
/* {% if this.layout.isSidebarSecondVisible() %}*/
/*   <div id="sidebar-second" class="column sidebar">*/
/*     <div class="section">*/
/*       {% if this.layout.isSidebarSingle() %}*/
/*       	{{ widget('XLite\\View\\ListContainer', innerList='sidebar.single', group='sidebar') }}*/
/*       {% else %}*/
/*       	{{ widget('XLite\\View\\ListContainer', innerList='sidebar.second', group='sidebar') }}*/
/*       {% endif %}*/
/*     </div>*/
/*   </div>*/
/* {% endif %}*/
/* */

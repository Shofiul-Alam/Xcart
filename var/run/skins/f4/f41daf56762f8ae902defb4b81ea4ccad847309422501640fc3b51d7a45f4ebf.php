<?php

/* layout/header/header_settings/links.twig */
class __TwigTemplate_d2cdf7a451fd51f0450b69f027167c7331265178b5c380422b2649744d5415c4 extends \XLite\Core\Templating\Twig\Template
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
";
        // line 8
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getViewList", array(0 => "slidebar.additional-menu.links"), "method")) {
            // line 9
            echo "    ";
            ob_start();
            // line 10
            echo "    <ul class='quick-links'>
    \t";
            // line 11
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "slidebar.additional-menu.links"))), "html", null, true);
            echo "
    </ul>
    ";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        }
    }

    public function getTemplateName()
    {
        return "layout/header/header_settings/links.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 11,  27 => 10,  24 => 9,  22 => 8,  19 => 7,);
    }
}
/* {##*/
/*  # Quick links*/
/*  #*/
/*  # @ListChild (list="slidebar.additional-menu", weight="100")*/
/*  # @ListChild (list="layout.header.right.settings", weight="100")*/
/*  #}*/
/* */
/* {% if this.getViewList('slidebar.additional-menu.links') %}*/
/*     {% spaceless %}*/
/*     <ul class='quick-links'>*/
/*     	{{ widget_list('slidebar.additional-menu.links') }}*/
/*     </ul>*/
/*     {% endspaceless %}*/
/* {% endif %}*/
/* */

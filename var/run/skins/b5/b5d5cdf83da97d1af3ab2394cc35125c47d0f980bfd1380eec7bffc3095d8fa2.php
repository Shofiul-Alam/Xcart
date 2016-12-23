<?php

/* header/parts/meta_keywords.twig */
class __TwigTemplate_f139bbd52d1c44985b12e7da71675343b2d7377856bf36dbb5cd8ee3d5b94a6f extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getKeywords", array(), "method")) {
            // line 8
            echo "  <meta name=\"keywords\" content=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getKeywords", array(), "method"))), "html", null, true);
            echo "\" />
";
        }
    }

    public function getTemplateName()
    {
        return "header/parts/meta_keywords.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 8,  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Head list children*/
/*  #*/
/*  # @ListChild (list="head", weight="700")*/
/*  #}*/
/* */
/* {% if this.getKeywords() %}*/
/*   <meta name="keywords" content="{{ t(this.getKeywords()) }}" />*/
/* {% endif %}*/
/* */

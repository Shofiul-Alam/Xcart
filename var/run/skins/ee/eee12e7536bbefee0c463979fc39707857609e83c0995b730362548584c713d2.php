<?php

/* header/parts/meta_description.twig */
class __TwigTemplate_d7709593e76953431fbc4f87dbdfe08bf73d185f4e73b9aa6d3c375f92cc8d7d extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMetaDescription", array(), "method")) {
            // line 8
            echo "  <meta name=\"description\" content=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMetaDescription", array(), "method"))), "html", null, true);
            echo "\" />
";
        }
    }

    public function getTemplateName()
    {
        return "header/parts/meta_description.twig";
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
/*  # @ListChild (list="head", weight="600")*/
/*  #}*/
/* */
/* {% if this.getMetaDescription() %}*/
/*   <meta name="description" content="{{ t(this.getMetaDescription()) }}" />*/
/* {% endif %}*/
/* */

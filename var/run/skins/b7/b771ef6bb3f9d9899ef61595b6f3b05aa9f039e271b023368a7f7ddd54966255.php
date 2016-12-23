<?php

/* header/parts/alternate_lang.twig */
class __TwigTemplate_b4e6639c4ff3077891d4519e6c10d3f8e62fd6100be5fad9f7303dd95b1ab3c3 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "hasAlternateLangUrls", array(), "method")) {
            // line 8
            echo "  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAlternateLangUrls", array(), "method"));
            foreach ($context['_seq'] as $context["code"] => $context["url"]) {
                // line 9
                echo "    <link rel=\"alternate\" hreflang=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["code"], "html", null, true);
                echo "\" href=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["url"], "html", null, true);
                echo "\"/>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['code'], $context['url'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "header/parts/alternate_lang.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 9,  24 => 8,  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Alternate languages links*/
/*  #*/
/*  # @ListChild (list="head", weight="3")*/
/*  #}*/
/* */
/* {% if this.hasAlternateLangUrls() %}*/
/*   {% for code, url in this.getAlternateLangUrls() %}*/
/*     <link rel="alternate" hreflang="{{ code }}" href="{{ url }}"/>*/
/*   {% endfor %}*/
/* {% endif %}*/
/* */

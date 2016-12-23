<?php

/* common/image.twig */
class __TwigTemplate_dd92fd87f8cfa8addb615fd777838e0a95ae76075f68c894277feff6ce387691 extends \XLite\Core\Templating\Twig\Template
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
        echo "<img src=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getURL", array(), "method"), "html", null, true);
        echo "\" alt=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAlt", array(), "method"), "html", null, true);
        echo "\" ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProperties", array(), "method"));
        foreach ($context['_seq'] as $context["name"] => $context["value"]) {
            echo " ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "\"";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo " />
";
    }

    public function getTemplateName()
    {
        return "common/image.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 4,);
    }
}
/* {##*/
/*  # Image*/
/*  #}*/
/* <img src="{{ this.getURL() }}" alt="{{ this.getAlt() }}" {% for name, value in this.getProperties() %} {{ name }}="{{ value }}"{% endfor %} />*/
/* */

<?php

/* modules/XC/ProductFilter/sidebar/attributes.twig */
class __TwigTemplate_eee67df795b4c6968be0e75b0b7b3b54c5ddb4ddebb537c3ff5a12b1ef60cb0e extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAttributesList", array(), "method")) {
            // line 6
            echo "<div class=\"filter attributes";
            if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getTitle", array(), "method")) {
                echo " group";
            }
            echo "\">
  ";
            // line 7
            if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getTitle", array(), "method")) {
                // line 8
                echo "    <div class=\"head-h4\">";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getTitle", array(), "method"), "html", null, true);
                echo "</div>
  ";
            }
            // line 10
            echo "  <ul class=\"clearfix attributes\">
    ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAttributesList", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["a"]) {
                // line 12
                echo "      <li class=\"clearfix ";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["a"], "class", array()), "html", null, true);
                echo "\">
        ";
                // line 13
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["a"], "widget", array()), "display", array(), "method"), "html", null, true);
                echo "
      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['a'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 16
            echo "  </ul>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/sidebar/attributes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 16,  51 => 13,  46 => 12,  42 => 11,  39 => 10,  33 => 8,  31 => 7,  24 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Attributes */
/*  #}*/
/* */
/* {% if this.getAttributesList() %}*/
/* <div class="filter attributes{% if this.getTitle() %} group{% endif %}">*/
/*   {% if this.getTitle() %}*/
/*     <div class="head-h4">{{ this.getTitle() }}</div>*/
/*   {% endif %}*/
/*   <ul class="clearfix attributes">*/
/*     {% for a in this.getAttributesList() %}*/
/*       <li class="clearfix {{ a.class }}">*/
/*         {{ a.widget.display() }}*/
/*       </li>*/
/*     {% endfor %}*/
/*   </ul>*/
/* </div>*/
/* {% endif %}*/
/* */

<?php

/* modules/XC/ProductFilter/form_field/value_range/input.twig */
class __TwigTemplate_37ddaf0a8c56dc5864d4ffd39c4fe06e2cfe289cae1a17c215ad384f60930fc0 extends \XLite\Core\Templating\Twig\Template
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
        if ( !$this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayLabelOnly", array(), "method")) {
            // line 6
            echo "  <div class=\"value-range\">
    ";
            // line 7
            if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getUnit", array(), "method")) {
                // line 8
                echo "      <span class=\"unit\">";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getUnit", array(), "method"), "html", null, true);
                echo "</span>
    ";
            }
            // line 10
            echo "    <input type=\"text\" value=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getRangeValue", array(0 => 0), "method"), "html", null, true);
            echo "\" name=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
            echo "[0]\" class=\"min-value form-control\" placeholder=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMinValue", array(), "method"), "html", null, true);
            echo "\" /> 
    <span class=\"dash\">&mdash;</span> 
    <input type=\"text\" value=\"";
            // line 12
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getRangeValue", array(0 => 1), "method"), "html", null, true);
            echo "\" name=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
            echo "[1]\" class=\"max-value form-control\" placeholder=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMaxValue", array(), "method"), "html", null, true);
            echo "\" />
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/form_field/value_range/input.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 12,  35 => 10,  29 => 8,  27 => 7,  24 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Value range*/
/*  #}*/
/* */
/* {% if not this.displayLabelOnly() %}*/
/*   <div class="value-range">*/
/*     {% if this.getUnit() %}*/
/*       <span class="unit">{{ this.getUnit() }}</span>*/
/*     {% endif %}*/
/*     <input type="text" value="{{ this.getRangeValue(0) }}" name="{{ this.getName() }}[0]" class="min-value form-control" placeholder="{{ this.getMinValue() }}" /> */
/*     <span class="dash">&mdash;</span> */
/*     <input type="text" value="{{ this.getRangeValue(1) }}" name="{{ this.getName() }}[1]" class="max-value form-control" placeholder="{{ this.getMaxValue() }}" />*/
/*   </div>*/
/* {% endif %}*/
/* */

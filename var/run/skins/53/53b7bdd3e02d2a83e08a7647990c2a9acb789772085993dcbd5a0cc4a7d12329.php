<?php

/* modules/XC/ProductFilter/form_field/select/checkbox_list/select.twig */
class __TwigTemplate_88268bc6f3efc1c4d37501f0324393d1ce2a5152e6fe59f16f374bf8041fe821 extends \XLite\Core\Templating\Twig\Template
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
<div class=\"fade-up\"> </div>
<ul id=\"";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getFieldId", array(), "method"), "html", null, true);
        echo "\">
  ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getOptions", array(), "method"));
        foreach ($context['_seq'] as $context["optionValue"] => $context["optionLabel"]) {
            // line 8
            echo "    <li";
            if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isOptionSelected", array(0 => $context["optionValue"]), "method")) {
                echo " class=\"checked\"";
            }
            echo ">
      <input id=\"";
            // line 9
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
            echo "_";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["optionValue"], "html", null, true);
            echo "\" type=\"checkbox\" value=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["optionValue"], "html", null, true);
            echo "\" ";
            if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isOptionSelected", array(0 => $context["optionValue"]), "method")) {
                echo " checked=\"checked\" ";
            }
            echo " name=\"";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
            echo "[";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["optionValue"], "html", null, true);
            echo "]\" />
      <label for=\"";
            // line 10
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
            echo "_";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["optionValue"], "html", null, true);
            echo "\">";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["optionLabel"], "html", null, true);
            echo "</label>
    </li>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['optionValue'], $context['optionLabel'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "</ul>
<div class=\"fade-down\"> </div>
";
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/form_field/select/checkbox_list/select.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 13,  54 => 10,  38 => 9,  31 => 8,  27 => 7,  23 => 6,  19 => 4,);
    }
}
/* {##*/
/*  # Common selector*/
/*  #}*/
/* */
/* <div class="fade-up"> </div>*/
/* <ul id="{{ this.getFieldId() }}">*/
/*   {% for optionValue, optionLabel in this.getOptions() %}*/
/*     <li{% if this.isOptionSelected(optionValue) %} class="checked"{% endif %}>*/
/*       <input id="{{ this.getName() }}_{{ optionValue }}" type="checkbox" value="{{ optionValue }}" {% if this.isOptionSelected(optionValue) %} checked="checked" {% endif %} name="{{ this.getName() }}[{{ optionValue }}]" />*/
/*       <label for="{{ this.getName() }}_{{ optionValue }}">{{ optionLabel }}</label>*/
/*     </li>*/
/*   {% endfor %}*/
/* </ul>*/
/* <div class="fade-down"> </div>*/
/* */

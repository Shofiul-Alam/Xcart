<?php

/* modules/XC/ProductFilter/filter/price_range/body.twig */
class __TwigTemplate_4c578162c3c9eb21fc52236e66e28cbf8eca8478aace7d4b902a5c3cfa6a8a40 extends \XLite\Core\Templating\Twig\Template
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
<div class=\"filter price-range\">
  ";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\Module\\XC\\ProductFilter\\View\\FormField\\ValueRange\\ValueRange", "fieldName" => "filter[price]", "useColon" => "false", "label" => "Price range", "value" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getValue", array(), "method"), "isOpened" => "true", "minValue" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMinPrice", array(), "method"), "maxValue" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMaxPrice", array(), "method"), "unit" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getSymbol", array(), "method")))), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/filter/price_range/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  23 => 6,  19 => 4,);
    }
}
/* {##*/
/*  # Body*/
/*  #}*/
/* */
/* <div class="filter price-range">*/
/*   {{ widget('XLite\\Module\\XC\\ProductFilter\\View\\FormField\\ValueRange\\ValueRange', fieldName='filter[price]', useColon='false', label='Price range', value=this.getValue(), isOpened='true', minValue=this.getMinPrice(), maxValue=this.getMaxPrice(), unit=this.getSymbol()) }}*/
/* </div>*/
/* */

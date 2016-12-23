<?php

/* modules/XC/ProductFilter/filter/in_stock_only/body.twig */
class __TwigTemplate_92a480de7a7f8341a7977262f3b753678b8466db8c6a4ba6dfbfb210ca2cb858 extends \XLite\Core\Templating\Twig\Template
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
<div class=\"filter type-c clearfix";
        // line 5
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getValue", array(), "method")) {
            echo " checked";
        }
        echo "\">
  ";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\View\\FormField\\Input\\Checkbox\\Enabled", "fieldName" => "filter[inStock]", "useColon" => "false", "label" => "In stock only", "value" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getValue", array(), "method")))), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/filter/in_stock_only/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Body*/
/*  #}*/
/* */
/* <div class="filter type-c clearfix{% if this.getValue() %} checked{% endif %}">*/
/*   {{ widget('XLite\\View\\FormField\\Input\\Checkbox\\Enabled', fieldName='filter[inStock]', useColon='false', label='In stock only', value=this.getValue()) }}*/
/* </div>*/
/* */

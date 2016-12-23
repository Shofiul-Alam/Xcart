<?php

/* mini_cart/horizontal/parts/checkout.twig */
class __TwigTemplate_ff9de674929512f8e089389ace93e7257c8bd31035502746006a63bf48e3c4d9 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "cart", array()), "checkCart", array(), "method")) {
            // line 7
            echo "  ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Button\\SimpleLink", "label" => "Checkout", "location" => call_user_func_array($this->env->getFunction('url')->getCallable(), array($this->env, $context, "checkout")), "style" => "regular-main-button checkout"))), "html", null, true);
            echo "
";
        }
        // line 9
        if ( !$this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "cart", array()), "checkCart", array(), "method")) {
            // line 10
            echo "  ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Button\\SimpleLink", "label" => "Checkout", "location" => call_user_func_array($this->env->getFunction('url')->getCallable(), array($this->env, $context, "checkout")), "style" => "regular-main-button checkout", "disabled" => "true"))), "html", null, true);
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "mini_cart/horizontal/parts/checkout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 10,  27 => 9,  21 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Horizontal minicart checkout button block*/
/*  #*/
/*  # @ListChild (list="minicart.horizontal.buttons", weight="10")*/
/*  #}*/
/* {% if this.cart.checkCart() %}*/
/*   {{ widget('\\XLite\\View\\Button\\SimpleLink', label='Checkout', location=url('checkout'), style='regular-main-button checkout') }}*/
/* {% endif %}*/
/* {% if not this.cart.checkCart() %}*/
/*   {{ widget('\\XLite\\View\\Button\\SimpleLink', label='Checkout', location=url('checkout'), style='regular-main-button checkout', disabled='true') }}*/
/* {% endif %}*/
/* */

<?php

/* modules/Amazon/PayWithAmazon/checkout_button/mini_cart.twig */
class __TwigTemplate_df115a019c1f1aff0cafc4411567b2f410f4d6b17f2a374f7639e71c39d9d645 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isPayWithAmazonActive", array(), "method")) {
            // line 7
            echo "<div id=\"payWithAmazonDiv_mini_cart_btn\" class=\"pay-with-amazon-button\">
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/Amazon/PayWithAmazon/checkout_button/mini_cart.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Template*/
/*  #*/
/*  # @ListChild (list="minicart.horizontal.buttons", weight="1000")*/
/*  #}*/
/* {% if this.isPayWithAmazonActive() %}*/
/* <div id="payWithAmazonDiv_mini_cart_btn" class="pay-with-amazon-button">*/
/* </div>*/
/* {% endif %}*/
/* */

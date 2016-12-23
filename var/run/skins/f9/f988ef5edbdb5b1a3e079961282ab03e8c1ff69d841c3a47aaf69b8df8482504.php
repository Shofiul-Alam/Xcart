<?php

/* modules/XC/FastLaneCheckout/layout/header/header.bar.checkout.logos.twig */
class __TwigTemplate_1a3890377309f95ef364b5dd3c990b03f668b2c5e9bcabf283369f9d6a5776bd extends \XLite\Core\Templating\Twig\Template
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
        // line 8
        echo "
";
        // line 9
        if (($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isCheckoutLayout", array(), "method") && $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isFastlaneEnabled", array(), "method"))) {
            // line 10
            echo "  <div class=\"header-checkout_logos\">
    <img src=\"";
            // line 11
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('asset')->getCallable(), array("images/checkout_logos.png")), "html", null, true);
            echo "\" title=\"Safe & Secure checkout\">
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/XC/FastLaneCheckout/layout/header/header.bar.checkout.logos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 11,  24 => 10,  22 => 9,  19 => 8,);
    }
}
/* {##*/
/*  # Header bar account links*/
/*  #*/
/*  # @ListChild (list="layout.header", weight="190")*/
/*  # @ListChild (list="layout.header.right.mobile", weight="1100")*/
/*  # @ListChild (list="checkout_fastlane.header.top", weight="100")*/
/*  #}*/
/* */
/* {% if this.isCheckoutLayout() and this.isFastlaneEnabled() %}*/
/*   <div class="header-checkout_logos">*/
/*     <img src="{{ asset('images/checkout_logos.png') }}" title="Safe & Secure checkout">*/
/*   </div>*/
/* {% endif %}*/

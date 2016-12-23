<?php

/* mini_cart/horizontal/parts/disabled_reason.twig */
class __TwigTemplate_deb5e98881e0311d58965d91cc4f0d4adf01781b709037c47b1daa5bae9c1fa7 extends \XLite\Core\Templating\Twig\Template
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
        if ( !$this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "cart", array()), "checkCart", array(), "method")) {
            // line 7
            echo "  <div class=\"reason-details\">
    ";
            // line 8
            echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDisabledReason", array(), "method");
            echo "
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "mini_cart/horizontal/parts/disabled_reason.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 8,  21 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Horizontal minicart checkout button block*/
/*  #*/
/*  # @ListChild (list="minicart.horizontal.buttons", weight="20")*/
/*  #}*/
/* {% if not this.cart.checkCart() %}*/
/*   <div class="reason-details">*/
/*     {{ this.getDisabledReason()|raw }}*/
/*   </div>*/
/* {% endif %}*/
/* */

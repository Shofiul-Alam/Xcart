<?php

/* items_list/product/sidebar/small_thumbnails/product.twig */
class __TwigTemplate_c8b646fb283e37a1ccb6dbd15ef5d67fb75b8ebddb77de8f96f7c05af7210493 extends \XLite\Core\Templating\Twig\Template
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
<div class=\"";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProductCellClass", array(), "method"), "html", null, true);
        echo "\">
  ";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "info", "type" => "inherited", "product" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "product", array())))), "html", null, true);
        echo "
  <div class=\"clear\"></div>
</div>";
    }

    public function getTemplateName()
    {
        return "items_list/product/sidebar/small_thumbnails/product.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Products list item (sidebar variant)*/
/*  #}*/
/* */
/* <div class="{{ this.getProductCellClass() }}">*/
/*   {{ widget_list('info', type='inherited', product=this.product) }}*/
/*   <div class="clear"></div>*/
/* </div>*/

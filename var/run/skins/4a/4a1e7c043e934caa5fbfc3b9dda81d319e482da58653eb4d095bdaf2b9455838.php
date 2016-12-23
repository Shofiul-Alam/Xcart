<?php

/* items_list/product/parts/common.product-price.twig */
class __TwigTemplate_f703616f143e851bf8ece2babcff4ecfc1d4f7823cecb3e47193e06f4bbb7451 extends \XLite\Core\Templating\Twig\Template
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
        // line 10
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Price", "product" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "product", array()), "displayOnlyPrice" => "1", "allowRange" => "1"))), "html", null, true);
    }

    public function getTemplateName()
    {
        return "items_list/product/parts/common.product-price.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 10,);
    }
}
/* {##*/
/*  # Item price*/
/*  #*/
/*  # @ListChild (list="itemsList.product.grid.customer.info", weight="30")*/
/*  # @ListChild (list="itemsList.product.small_thumbnails.customer.details", weight="25")*/
/*  # @ListChild (list="itemsList.product.list.customer.info", weight="40")*/
/*  # @ListChild (list="itemsList.product.table.customer.columns", weight="40")*/
/*  # @ListChild (list="productBlock.info", weight="300")*/
/*  #}*/
/* {{ widget('\\XLite\\View\\Price', product=this.product, displayOnlyPrice='1', allowRange='1') }}*/

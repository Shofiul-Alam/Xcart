<?php

/* items_list/product/parts/grid.photo.twig */
class __TwigTemplate_f2bc34953b58cf76e39d76537ca435d15918259c77842585bdedf3f362a2aea6 extends \XLite\Core\Templating\Twig\Template
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
        echo "<div class=\"product-photo lazy-load\">
  ";
        // line 9
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "photo", "type" => "nested", "product" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "product", array())))), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "items_list/product/parts/grid.photo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 9,  19 => 8,);
    }
}
/* {##*/
/*  # Products list (list variant)*/
/*  #*/
/*  # @ListChild (list="itemsList.product.grid.customer.info", weight="10")*/
/*  # @ListChild (list="itemsList.product.small_thumbnails.customer.info", weight="10")*/
/*  # @ListChild (list="itemsList.product.big_thumbnails.customer.info", weight="100")*/
/*  #}*/
/* <div class="product-photo lazy-load">*/
/*   {{ widget_list('photo', type='nested', product=this.product) }}*/
/* </div>*/
/* */
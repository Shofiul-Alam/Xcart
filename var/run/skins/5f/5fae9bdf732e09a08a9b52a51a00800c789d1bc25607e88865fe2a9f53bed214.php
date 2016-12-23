<?php

/* items_list/product/parts/small-thumbnails.details.twig */
class __TwigTemplate_f4a066e6532bcf75e36a82fd3faa3902aaa5b2ba3bbec992f25b8408e041a0ac extends \XLite\Core\Templating\Twig\Template
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
        echo "<div class=\"details\">
  ";
        // line 7
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "details", "type" => "inherited", "product" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "product", array())))), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "items_list/product/parts/small-thumbnails.details.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Item name*/
/*  #*/
/*  # @ListChild (list="itemsList.product.small_thumbnails.customer.info", weight="20")*/
/*  #}*/
/* <div class="details">*/
/*   {{ widget_list('details', type='inherited', product=this.product) }}*/
/* </div>*/
/* */

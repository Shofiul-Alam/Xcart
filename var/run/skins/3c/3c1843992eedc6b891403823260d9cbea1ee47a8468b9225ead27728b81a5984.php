<?php

/* modules/XC/Reviews/average_rating/form.twig */
class __TwigTemplate_2e1aa9dcf552889df2a03e6f3fe9922a27188ee67a97e2c29b1096a6eb38c349 extends \XLite\Core\Templating\Twig\Template
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
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "reviews.product.rating.form.content"))), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "modules/XC/Reviews/average_rating/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 8,);
    }
}
/* {##*/
/*  # Rating*/
/*  #*/
/*  # @ListChild (list="reviews.product.rating", weight="100")*/
/*  # @ListChild (list="reviews.page.rating", weight="100")*/
/*  # @ListChild (list="reviews.tab.rating", weight="200")*/
/*  #}*/
/* {{ widget_list('reviews.product.rating.form.content') }}*/
/* */

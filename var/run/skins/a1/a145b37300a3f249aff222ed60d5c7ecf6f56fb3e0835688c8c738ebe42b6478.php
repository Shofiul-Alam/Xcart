<?php

/* product/search/simple-search-parts/submit.twig */
class __TwigTemplate_16701c2dcc4878a6af49cf4218dc7b4cd02ed335852b7dbb20197e37feadac31 extends \XLite\Core\Templating\Twig\Template
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
        echo "
";
        // line 7
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Button\\Submit", "style" => "submit-button", "label" => call_user_func_array($this->env->getFunction('t')->getCallable(), array("Search"))))), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "product/search/simple-search-parts/submit.twig";
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
/*  # Main element (input)*/
/*  #*/
/*  # @ListChild (list="product.simple-search-form.simple-box.elements", weight="20")*/
/*  #}*/
/* */
/* {{ widget('\\XLite\\View\\Button\\Submit', style='submit-button', label=t('Search')) }}*/
/* */

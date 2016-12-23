<?php

/* form_field/input.twig */
class __TwigTemplate_87606aeba959781a0c611c14c37e4e8819277c9fd9651c4a66649be3dd4b1ef3 extends \XLite\Core\Templating\Twig\Template
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
        echo "<span class=\"input-field-wrapper ";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getWrapperClass", array(), "method"), "html", null, true);
        echo "\">
  ";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayCommentedData", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getCommentedData", array(), "method")), "method"), "html", null, true);
        echo "
  <input";
        // line 6
        echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAttributesCode", array(), "method");
        echo " />
</span>
";
    }

    public function getTemplateName()
    {
        return "form_field/input.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 6,  24 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # ____file_title____*/
/*  #}*/
/* <span class="input-field-wrapper {{ this.getWrapperClass() }}">*/
/*   {{ this.displayCommentedData(this.getCommentedData()) }}*/
/*   <input{{ this.getAttributesCode()|raw }} />*/
/* </span>*/
/* */

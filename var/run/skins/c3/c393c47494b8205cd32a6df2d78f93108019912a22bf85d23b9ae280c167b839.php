<?php

/* form_field/checkbox.twig */
class __TwigTemplate_1c491169122aea695e17dce965fb93fece8da8dde208ebdff97ce91ef750f3cd extends \XLite\Core\Templating\Twig\Template
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
  <input type=\"hidden\" name=\"";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getName", array(), "method"), "html", null, true);
        echo "\" value=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDefaultHiddenValue", array(), "method"), "html", null, true);
        echo "\" />
  <input";
        // line 7
        echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAttributesCode", array(), "method");
        echo " />
</span>
";
    }

    public function getTemplateName()
    {
        return "form_field/checkbox.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 7,  28 => 6,  24 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Checkbox template*/
/*  #}*/
/* <span class="input-field-wrapper {{ this.getWrapperClass() }}">*/
/*   {{ this.displayCommentedData(this.getCommentedData()) }}*/
/*   <input type="hidden" name="{{ this.getName() }}" value="{{ this.getDefaultHiddenValue() }}" />*/
/*   <input{{ this.getAttributesCode()|raw }} />*/
/* </span>*/
/* */

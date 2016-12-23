<?php

/* button/popup_button.twig */
class __TwigTemplate_1ab144c61cee64e1c45f9b76f7e67fc950b892280b3221575f7d7d99985f3c38 extends \XLite\Core\Templating\Twig\Template
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
        echo "<button type=\"button\" class=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getClass", array(), "method"), "html", null, true);
        echo "\" ";
        echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "printTagAttributes", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAttributes", array(), "method")), "method");
        echo ">
";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayCommentedData", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getURLParams", array(), "method")), "method"), "html", null, true);
        echo "
<span>";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getButtonContent", array(), "method"))), "html", null, true);
        echo "</span>
</button>
";
    }

    public function getTemplateName()
    {
        return "button/popup_button.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 6,  26 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Popup button*/
/*  #}*/
/* <button type="button" class="{{ this.getClass() }}" {{ this.printTagAttributes(this.getAttributes())|raw }}>*/
/* {{ this.displayCommentedData(this.getURLParams()) }}*/
/* <span>{{ t(this.getButtonContent()) }}</span>*/
/* </button>*/
/* */

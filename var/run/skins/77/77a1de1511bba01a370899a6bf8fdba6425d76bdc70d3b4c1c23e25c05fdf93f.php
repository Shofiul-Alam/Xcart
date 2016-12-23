<?php

/* modules/XC/ProductFilter/filter/attributes/body.twig */
class __TwigTemplate_3ca13c73210cf650d6aa97dc755d8ec7331dcea877e9f7c767df51431f78139d extends \XLite\Core\Templating\Twig\Template
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
";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList"))), "html", null, true);
        echo "
";
        // line 6
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProductClasses", array(), "method")) {
            // line 7
            echo "  ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList", "classes" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProductClasses", array(), "method")))), "html", null, true);
            echo "
";
        }
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getGlobalGroups", array(), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
            // line 10
            echo "  ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList", "group" => $context["group"]))), "html", null, true);
            echo "
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProductClasses", array(), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["productClass"]) {
            // line 13
            echo "  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["productClass"], "getAttributeGroups", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 14
                echo "    ";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList", "group" => $context["group"]))), "html", null, true);
                echo "
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['productClass'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/filter/attributes/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 14,  51 => 13,  47 => 12,  38 => 10,  34 => 9,  28 => 7,  26 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Body*/
/*  #}*/
/* */
/* {{ widget('XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList') }}*/
/* {% if this.getProductClasses() %}*/
/*   {{ widget('XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList', classes=this.getProductClasses()) }}*/
/* {% endif %}*/
/* {% for group in this.getGlobalGroups() %}*/
/*   {{ widget('XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList', group=group) }}*/
/* {% endfor %}*/
/* {% for productClass in this.getProductClasses() %}*/
/*   {% for group in productClass.getAttributeGroups() %}*/
/*     {{ widget('XLite\\Module\\XC\\ProductFilter\\View\\Filter\\AttributeList', group=group) }}*/
/*   {% endfor %}*/
/* {% endfor %}*/
/* */

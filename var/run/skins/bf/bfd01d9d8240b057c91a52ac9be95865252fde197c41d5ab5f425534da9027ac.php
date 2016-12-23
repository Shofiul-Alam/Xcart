<?php

/* modules/XC/ProductFilter/sidebar/body.twig */
class __TwigTemplate_fcbf0c3cf03384e123aad406d6ee611ebcd805ddb09a820a7bfdb8db3c00166d extends \XLite\Core\Templating\Twig\Template
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
<div class=\"product-filter\">
    ";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayCommentedData", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getCommentedData", array(), "method")), "method"), "html", null, true);
        echo "
    <div class=\"";
        // line 7
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getBlockClasses", array(), "method"), "html", null, true);
        echo "\">
        <h4>";
        // line 8
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getHead", array(), "method"))), "html", null, true);
        echo "</h4>
        <div class=\"content\">
            ";
        // line 10
        $this->startForm("\\XLite\\Module\\XC\\ProductFilter\\View\\Form\\Filter", array("category" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getCategory", array(), "method")));        // line 11
        echo "            ";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "sidebar.filter"))), "html", null, true);
        echo "
            <div class=\"buttons\">
                <div class=\"popup\">
                    <a href=\"#\" class=\"show-products\">";
        // line 14
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Show products")), "html", null, true);
        echo "</a>
                    <div class=\"arrow\"> </div>
                </div>
                ";
        // line 17
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Button\\Submit", "label" => "Show products", "style" => "filter"))), "html", null, true);
        echo "
                ";
        // line 18
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isFilterTarget", array(), "method")) {
            // line 19
            echo "                    <a href=\"#\" class=\"reset-filter\">";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Reset filter")), "html", null, true);
            echo "</a>
                ";
        }
        // line 21
        echo "            </div>
            ";
        $this->endForm();        // line 23
        echo "        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/XC/ProductFilter/sidebar/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 23,  62 => 21,  56 => 19,  54 => 18,  50 => 17,  44 => 14,  37 => 11,  36 => 10,  31 => 8,  27 => 7,  23 => 6,  19 => 4,);
    }
}
/* {##*/
/*  # Body*/
/*  #}*/
/* */
/* <div class="product-filter">*/
/*     {{ this.displayCommentedData(this.getCommentedData()) }}*/
/*     <div class="{{ this.getBlockClasses() }}">*/
/*         <h4>{{ t(this.getHead()) }}</h4>*/
/*         <div class="content">*/
/*             {% form '\\XLite\\Module\\XC\\ProductFilter\\View\\Form\\Filter' with {category: this.getCategory()} %}*/
/*             {{ widget_list('sidebar.filter') }}*/
/*             <div class="buttons">*/
/*                 <div class="popup">*/
/*                     <a href="#" class="show-products">{{ t('Show products') }}</a>*/
/*                     <div class="arrow"> </div>*/
/*                 </div>*/
/*                 {{ widget('\\XLite\\View\\Button\\Submit', label='Show products', style='filter') }}*/
/*                 {% if this.isFilterTarget() %}*/
/*                     <a href="#" class="reset-filter">{{ t('Reset filter') }}</a>*/
/*                 {% endif %}*/
/*             </div>*/
/*             {% endform %}*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */

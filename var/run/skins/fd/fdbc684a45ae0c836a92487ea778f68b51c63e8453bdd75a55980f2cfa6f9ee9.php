<?php

/* modules/QSL/CloudSearch/cloud_filters/sidebar_box/container.twig */
class __TwigTemplate_b6b9c6aac6af158467a7104300eabb86ca0261c62878ac54b64d4c17c4a1f7a8 extends \XLite\Core\Templating\Twig\Template
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
        // line 2
        echo "
<div id=\"cloud-filters\" class=\"cloud-filters\" v-cloak>
    ";
        // line 4
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayCommentedData", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getPhpToJsData", array(), "method")), "method"), "html", null, true);
        echo "

    <div v-if=\"isVisible()\">
        ";
        // line 7
        echo call_user_func_array($this->env->getFunction('include')->getCallable(), array($this->env, $context, "common/sidebar_box.twig"));
        echo "
    </div>
</div>

";
        // line 11
        $context["tplPath"] = "modules/QSL/CloudSearch/cloud_filters/filters/";
        // line 12
        echo "
";
        // line 13
        echo call_user_func_array($this->env->getFunction('include')->getCallable(), array($this->env, $context, ((isset($context["tplPath"]) ? $context["tplPath"] : null) . "default.vue.twig")));
        echo "
";
        // line 14
        echo call_user_func_array($this->env->getFunction('include')->getCallable(), array($this->env, $context, ((isset($context["tplPath"]) ? $context["tplPath"] : null) . "price.vue.twig")));
        echo "
";
        // line 15
        echo twig_source($this->env, ((isset($context["tplPath"]) ? $context["tplPath"] : null) . "value_renderers/text.vue.html"));
        echo "
";
        // line 16
        echo twig_source($this->env, ((isset($context["tplPath"]) ? $context["tplPath"] : null) . "value_renderers/color.vue.html"));
        echo "
";
        // line 17
        echo twig_source($this->env, ((isset($context["tplPath"]) ? $context["tplPath"] : null) . "value_renderers/category.vue.html"));
    }

    public function getTemplateName()
    {
        return "modules/QSL/CloudSearch/cloud_filters/sidebar_box/container.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 17,  53 => 16,  49 => 15,  45 => 14,  41 => 13,  38 => 12,  36 => 11,  29 => 7,  23 => 4,  19 => 2,);
    }
}
/* {# Root Vuejs element #}*/
/* */
/* <div id="cloud-filters" class="cloud-filters" v-cloak>*/
/*     {{ this.displayCommentedData(this.getPhpToJsData()) }}*/
/* */
/*     <div v-if="isVisible()">*/
/*         {{ include('common/sidebar_box.twig') }}*/
/*     </div>*/
/* </div>*/
/* */
/* {% set tplPath = 'modules/QSL/CloudSearch/cloud_filters/filters/' %}*/
/* */
/* {{ include(tplPath ~ 'default.vue.twig') }}*/
/* {{ include(tplPath ~ 'price.vue.twig') }}*/
/* {{ source(tplPath ~ 'value_renderers/text.vue.html') }}*/
/* {{ source(tplPath ~ 'value_renderers/color.vue.html') }}*/
/* {{ source(tplPath ~ 'value_renderers/category.vue.html') }}*/

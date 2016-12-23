<?php

/* modules/QSL/CloudSearch/cloud_filters/filters/price.vue.twig */
class __TwigTemplate_b941f7f46a702da2fe006f5177b428a204bcea4e174bfca27a42ab3f79e8c370 extends \XLite\Core\Templating\Twig\Template
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
        // line 1
        echo "<script type=\"x-template\" id=\"cloud-filters-template-price\">

    <div class=\"cloud-filters-filter cloud-filters-filter-price\">
        <h4 class=\"cloud-filters-filter__title\">";
        // line 4
        echo "{{";
        echo " title ";
        echo "}}";
        echo "</h4>

        <form class=\"form-inline\">
            <input type=\"text\"
                   v-model=\"min[0] | priceFilterValue\"
                   debounce=\"500\"
                   :placeholder=\"statsMin !== null ? statsMin.toFixed(2) : '";
        // line 10
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("From")), "html", null, true);
        echo "'\"
                   class=\"form-control cloud-filters-filter-price__input\">
            &mdash;
            <input type=\"text\"
                   v-model=\"max[0] | priceFilterValue\"
                   debounce=\"500\"
                   :placeholder=\"statsMax !== null ? statsMax.toFixed(2) : '";
        // line 16
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("To")), "html", null, true);
        echo "'\"
                   class=\"form-control cloud-filters-filter-price__input\">
        </form>

    </div>

</script>";
    }

    public function getTemplateName()
    {
        return "modules/QSL/CloudSearch/cloud_filters/filters/price.vue.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  44 => 16,  35 => 10,  24 => 4,  19 => 1,);
    }
}
/* <script type="x-template" id="cloud-filters-template-price">*/
/* */
/*     <div class="cloud-filters-filter cloud-filters-filter-price">*/
/*         <h4 class="cloud-filters-filter__title">{{ '{{' }} title {{ '}}' }}</h4>*/
/* */
/*         <form class="form-inline">*/
/*             <input type="text"*/
/*                    v-model="min[0] | priceFilterValue"*/
/*                    debounce="500"*/
/*                    :placeholder="statsMin !== null ? statsMin.toFixed(2) : '{{ t('From') }}'"*/
/*                    class="form-control cloud-filters-filter-price__input">*/
/*             &mdash;*/
/*             <input type="text"*/
/*                    v-model="max[0] | priceFilterValue"*/
/*                    debounce="500"*/
/*                    :placeholder="statsMax !== null ? statsMax.toFixed(2) : '{{ t('To') }}'"*/
/*                    class="form-control cloud-filters-filter-price__input">*/
/*         </form>*/
/* */
/*     </div>*/
/* */
/* </script>*/

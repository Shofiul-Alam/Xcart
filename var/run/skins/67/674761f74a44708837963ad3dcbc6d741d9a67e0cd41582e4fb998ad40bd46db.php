<?php

/* modules/QSL/CloudSearch/cloud_filters/sidebar_box/body.twig */
class __TwigTemplate_98774d88af46f1d36151cf7e26057c201c30b4339709b2f18c9332fba4e667e4 extends \XLite\Core\Templating\Twig\Template
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
<category-filter
        v-if=\"facets.category\"
        id=\"category\"
        title=\"";
        // line 6
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Category")), "html", null, true);
        echo "\"
        :facet=\"facets.category\"
        :toggled-values=\"filters.category\"
        :on-toggle=\"toggleFilterAction\">
</category-filter>

<price-filter
        title=\"";
        // line 13
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Price")), "html", null, true);
        echo "\"
        :min=\"filters.min_price\"
        :max=\"filters.max_price\"
        :stats-min=\"stats.price.min\"
        :stats-max=\"stats.price.max\"
>
</price-filter>

<default-filter
        v-if=\"facets.manufacturer\"
        id=\"manufacturer\"
        title=\"";
        // line 24
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Manufacturer")), "html", null, true);
        echo "\"
        :facet=\"facets.manufacturer\"
        :toggled-values=\"filters.manufacturer\"
        :on-toggle=\"toggleFilterAction\">
</default-filter>

<component :is=\"getFilterType(facet)\"
           v-for=\"facet in facets\" v-if=\"facet.id != 'category' && facet.id != 'manufacturer'\"
           :id=\"facet.id\"
           :title=\"facet.name\"
           :facet=\"facet\"
           :toggled-values=\"filters[facet.id]\"
           :on-toggle=\"toggleFilterAction\">
</component>

<a href=\"#\" v-show=\"isAnyFilterSet\" v-on:click.prevent=\"resetFiltersAction\"
   class=\"cloud-filters__reset\">
    <small>";
        // line 41
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Reset all filters")), "html", null, true);
        echo "</small>
</a>
";
    }

    public function getTemplateName()
    {
        return "modules/QSL/CloudSearch/cloud_filters/sidebar_box/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 41,  49 => 24,  35 => 13,  25 => 6,  19 => 2,);
    }
}
/* {# Render all filters #}*/
/* */
/* <category-filter*/
/*         v-if="facets.category"*/
/*         id="category"*/
/*         title="{{ t('Category') }}"*/
/*         :facet="facets.category"*/
/*         :toggled-values="filters.category"*/
/*         :on-toggle="toggleFilterAction">*/
/* </category-filter>*/
/* */
/* <price-filter*/
/*         title="{{ t('Price') }}"*/
/*         :min="filters.min_price"*/
/*         :max="filters.max_price"*/
/*         :stats-min="stats.price.min"*/
/*         :stats-max="stats.price.max"*/
/* >*/
/* </price-filter>*/
/* */
/* <default-filter*/
/*         v-if="facets.manufacturer"*/
/*         id="manufacturer"*/
/*         title="{{ t('Manufacturer') }}"*/
/*         :facet="facets.manufacturer"*/
/*         :toggled-values="filters.manufacturer"*/
/*         :on-toggle="toggleFilterAction">*/
/* </default-filter>*/
/* */
/* <component :is="getFilterType(facet)"*/
/*            v-for="facet in facets" v-if="facet.id != 'category' && facet.id != 'manufacturer'"*/
/*            :id="facet.id"*/
/*            :title="facet.name"*/
/*            :facet="facet"*/
/*            :toggled-values="filters[facet.id]"*/
/*            :on-toggle="toggleFilterAction">*/
/* </component>*/
/* */
/* <a href="#" v-show="isAnyFilterSet" v-on:click.prevent="resetFiltersAction"*/
/*    class="cloud-filters__reset">*/
/*     <small>{{ t('Reset all filters') }}</small>*/
/* </a>*/
/* */

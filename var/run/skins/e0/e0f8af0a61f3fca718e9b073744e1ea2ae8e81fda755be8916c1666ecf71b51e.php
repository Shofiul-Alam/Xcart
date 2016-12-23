<?php

/* modules/QSL/CloudSearch/cloud_filters/filters/default.vue.twig */
class __TwigTemplate_7c1d4d7bdfda4f5c6c4f40feeb5ba8e02e0a913ab23244063de5b96df5f02fb0 extends \XLite\Core\Templating\Twig\Template
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
        echo "<script type=\"x-template\" id=\"cloud-filters-template-default\">

    <div class=\"cloud-filters-filter\" v-if=\"values.length > 0\">
        <h4 class=\"cloud-filters-filter__title\">";
        // line 4
        echo "{{";
        echo " title ";
        echo "}}";
        echo "</h4>

        <ul>
            <li v-for=\"(index, valueCount) in foldedValues\">

                <div class=\"checkbox cloud-filters-filter-checkbox-container\">
                    <label class=\"cloud-filters-filter-label\" v-bind:class=\"{'cloud-filters-filter-label--zero-count': valueCount.count == 0, 'cloud-filters-filter-label--toggled': isToggled(valueCount.value)}\">

                        <input type=\"checkbox\"
                               v-bind:checked=\"isToggled(getFilterValue(valueCount.value))\"
                               v-on:change=\"onToggle(id, getFilterValue(valueCount.value), \$event.target.checked)\">

                        <component :is=\"getValueRenderer()\" :value=\"valueCount.value\">
                        </component>

                        <span class=\"cloud-filters-filter-label__count\" v-if=\"valueCount.count > 0\">
                            (";
        // line 20
        echo "{{";
        echo " valueCount.count ";
        echo "}}";
        echo ")
                        </span>

                    </label>
                </div>

            </li>
        </ul>

        <a href=\"#\" v-on:click.prevent=\"unfoldValues\" v-if=\"showUnfoldButton\" class=\"cloud-filters-filter__more\">
            ";
        // line 30
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("More")), "html", null, true);
        echo "
        </a>
    </div>

</script>";
    }

    public function getTemplateName()
    {
        return "modules/QSL/CloudSearch/cloud_filters/filters/default.vue.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 30,  45 => 20,  24 => 4,  19 => 1,);
    }
}
/* <script type="x-template" id="cloud-filters-template-default">*/
/* */
/*     <div class="cloud-filters-filter" v-if="values.length > 0">*/
/*         <h4 class="cloud-filters-filter__title">{{ '{{' }} title {{ '}}' }}</h4>*/
/* */
/*         <ul>*/
/*             <li v-for="(index, valueCount) in foldedValues">*/
/* */
/*                 <div class="checkbox cloud-filters-filter-checkbox-container">*/
/*                     <label class="cloud-filters-filter-label" v-bind:class="{'cloud-filters-filter-label--zero-count': valueCount.count == 0, 'cloud-filters-filter-label--toggled': isToggled(valueCount.value)}">*/
/* */
/*                         <input type="checkbox"*/
/*                                v-bind:checked="isToggled(getFilterValue(valueCount.value))"*/
/*                                v-on:change="onToggle(id, getFilterValue(valueCount.value), $event.target.checked)">*/
/* */
/*                         <component :is="getValueRenderer()" :value="valueCount.value">*/
/*                         </component>*/
/* */
/*                         <span class="cloud-filters-filter-label__count" v-if="valueCount.count > 0">*/
/*                             ({{ '{{' }} valueCount.count {{ '}}' }})*/
/*                         </span>*/
/* */
/*                     </label>*/
/*                 </div>*/
/* */
/*             </li>*/
/*         </ul>*/
/* */
/*         <a href="#" v-on:click.prevent="unfoldValues" v-if="showUnfoldButton" class="cloud-filters-filter__more">*/
/*             {{ t('More') }}*/
/*         </a>*/
/*     </div>*/
/* */
/* </script>*/

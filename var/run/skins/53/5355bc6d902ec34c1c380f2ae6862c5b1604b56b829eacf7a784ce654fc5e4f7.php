<?php

/* pager/parts/items_total.twig */
class __TwigTemplate_3c65dd9feeda1d9bca29bfa826145acbbc549c3bdee7792f62e004f44a0b8da9 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isItemsPerPageVisible", array(), "method")) {
            // line 5
            echo "  <div class=\"pager-items-total\">
    <span class=\"pager-items-label\">";
            // line 6
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Items")), "html", null, true);
            echo ":</span>
    <span class=\"pager-items-range\">";
            // line 7
            echo call_user_func_array($this->env->getFunction('t')->getCallable(), array("BEGIN - END of TOTAL", array("begin" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getBeginRecordNumber", array(), "method"), "end" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getEndRecordNumber", array(), "method"), "total" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getItemsTotal", array(), "method"))));
            echo "</span>
    ";
            // line 8
            if (($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isItemsPerPageSelectorVisible", array(), "method") && $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getPerPageCounts", array(), "method"))) {
                // line 9
                echo "      <div class=\"per-page-box\">
        <div>
          <span class=\"per-page-label\">";
                // line 11
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Show:")), "html", null, true);
                echo "</span>
          <span class=\"per-page-value\">";
                // line 12
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getItemsPerPage", array(), "method"), "html", null, true);
                echo "</span>
        </div>

        <ul class=\"display-per-page grid-list\">
          ";
                // line 16
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getPerPageCounts", array(), "method"));
                foreach ($context['_seq'] as $context["_key"] => $context["count"]) {
                    // line 17
                    echo "            <li class=\"list-type-grid ";
                    if (($context["count"] == $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getItemsPerPage", array(), "method"))) {
                        echo " selected";
                    }
                    echo "\">
              <a data-items-per-page=\"";
                    // line 18
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["count"], "html", null, true);
                    echo "\" href=\"#\">
                ";
                    // line 19
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["count"], "html", null, true);
                    echo "
              </a>
            </li>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['count'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 23
                echo "        </ul>

      </div>
    ";
            }
            // line 27
            echo "  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "pager/parts/items_total.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 27,  74 => 23,  64 => 19,  60 => 18,  53 => 17,  49 => 16,  42 => 12,  38 => 11,  34 => 9,  32 => 8,  28 => 7,  24 => 6,  21 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Products list items total*/
/*  #}*/
/* {% if this.isItemsPerPageVisible() %}*/
/*   <div class="pager-items-total">*/
/*     <span class="pager-items-label">{{ t('Items') }}:</span>*/
/*     <span class="pager-items-range">{{ t('BEGIN - END of TOTAL', {'begin': this.getBeginRecordNumber(), 'end': this.getEndRecordNumber(), 'total': this.getItemsTotal()})|raw }}</span>*/
/*     {% if this.isItemsPerPageSelectorVisible() and this.getPerPageCounts() %}*/
/*       <div class="per-page-box">*/
/*         <div>*/
/*           <span class="per-page-label">{{ t('Show:') }}</span>*/
/*           <span class="per-page-value">{{ this.getItemsPerPage() }}</span>*/
/*         </div>*/
/* */
/*         <ul class="display-per-page grid-list">*/
/*           {% for count in this.getPerPageCounts() %}*/
/*             <li class="list-type-grid {% if count == this.getItemsPerPage() %} selected{% endif %}">*/
/*               <a data-items-per-page="{{ count }}" href="#">*/
/*                 {{ count }}*/
/*               </a>*/
/*             </li>*/
/*           {% endfor %}*/
/*         </ul>*/
/* */
/*       </div>*/
/*     {% endif %}*/
/*   </div>*/
/* {% endif %}*/
/* */

<?php

/* /var/www/next/output/xcart/src/skins/pdf/common/order/invoice/parts/totals.includedModifiers.twig */
class __TwigTemplate_3fdfc5fd2bcf621bad1cf8ac26808620084ece8274ebdfaf287044ec70de6421 extends \XLite\Core\Templating\Twig\Template
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
        // line 6
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getItemsIncludeSurchargesTotals", array(), "method")) {
            // line 7
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getItemsIncludeSurchargesTotals", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 8
                echo "      <tr class='included-surcharge'>
        <td class=\"name\">";
                // line 9
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Including X", array("name" => $this->getAttribute($this->getAttribute($context["row"], "surcharge", array()), "getName", array(), "method")))), "html", null, true);
                echo ":</td>
        <td class=\"value\">";
                // line 10
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "formatPrice", array(0 => $this->getAttribute($context["row"], "cost", array()), 1 => $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "order", array()), "getCurrency", array(), "method")), "method"), "html", null, true);
                echo "</td>
      </tr>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "/var/www/next/output/xcart/src/skins/pdf/common/order/invoice/parts/totals.includedModifiers.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 10,  29 => 9,  26 => 8,  21 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Invoice totals : subtotal*/
/*  #*/
/*  # @ListChild (list="invoice.base.totals.after", weight="20")*/
/*  #}*/
/* {% if this.getItemsIncludeSurchargesTotals() %}*/
/*     {% for row in this.getItemsIncludeSurchargesTotals() %}*/
/*       <tr class='included-surcharge'>*/
/*         <td class="name">{{ t('Including X', {'name': row.surcharge.getName()}) }}:</td>*/
/*         <td class="value">{{ this.formatPrice(row.cost, this.order.getCurrency()) }}</td>*/
/*       </tr>*/
/*     {% endfor %}*/
/* {% endif %}*/
/* */

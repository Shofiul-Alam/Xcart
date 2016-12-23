<?php

/* pager/body.twig */
class __TwigTemplate_859a1f45722993a5b72fedbf707773fe36c59cc8daff5fd19ab0576264e1be28 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isPagesListVisible", array(), "method")) {
            // line 5
            echo "  <ul class=\"pagination grid-list\">
    ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getPages", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
                // line 7
                echo "      <li class=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["page"], "classes", array()), "html", null, true);
                echo "\">
        ";
                // line 8
                if ($this->getAttribute($context["page"], "href", array())) {
                    // line 9
                    echo "          <a href=\"";
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["page"], "href", array()), "html", null, true);
                    echo "\" class=\"";
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["page"], "page", array()), "html", null, true);
                    echo "\" title=\"";
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute($context["page"], "title", array()))), "html", null, true);
                    echo "\">";
                    echo call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute($context["page"], "text", array())));
                    echo "</a>
        ";
                }
                // line 11
                echo "        ";
                if ( !$this->getAttribute($context["page"], "href", array())) {
                    // line 12
                    echo "          <span class=\"";
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["page"], "page", array()), "html", null, true);
                    echo "\" title=\"";
                    echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute($context["page"], "title", array()))), "html", null, true);
                    echo "\">";
                    echo call_user_func_array($this->env->getFunction('t')->getCallable(), array($this->getAttribute($context["page"], "text", array())));
                    echo "</span>
        ";
                }
                // line 14
                echo "      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 16
            echo "  </ul>
";
        }
        // line 18
        echo "
";
        // line 19
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "itemsTotal", "type" => "inherited"))), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "pager/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 19,  71 => 18,  67 => 16,  60 => 14,  50 => 12,  47 => 11,  35 => 9,  33 => 8,  28 => 7,  24 => 6,  21 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Pager*/
/*  #}*/
/* {% if this.isPagesListVisible() %}*/
/*   <ul class="pagination grid-list">*/
/*     {% for page in this.getPages() %}*/
/*       <li class="{{ page.classes }}">*/
/*         {% if page.href %}*/
/*           <a href="{{ page.href }}" class="{{ page.page }}" title="{{ t(page.title) }}">{{ t(page.text)|raw }}</a>*/
/*         {% endif %}*/
/*         {% if not page.href %}*/
/*           <span class="{{ page.page }}" title="{{ t(page.title) }}">{{ t(page.text)|raw }}</span>*/
/*         {% endif %}*/
/*       </li>*/
/*     {% endfor %}*/
/*   </ul>*/
/* {% endif %}*/
/* */
/* {{ widget_list('itemsTotal', type='inherited') }}*/
/* */

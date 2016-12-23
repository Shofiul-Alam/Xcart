<?php

/* items_list/product/sidebar/small_thumbnails/body.twig */
class __TwigTemplate_4d0a94249f7363021dd919a53626c40513e700a3fadaf0a8914aaa40e6d981f5 extends \XLite\Core\Templating\Twig\Template
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
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget_list')->getCallable(), array($this->env, $context, array(0 => "itemsList.product.cart"))), "html", null, true);
        echo "

<ul class=\"list-body-sidebar products products-sidebar products-sidebar-small-thumbnails\">

  ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getSideBarData", array(), "method"));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["i"] => $context["product"]) {
            // line 10
            echo "    <li class=\"product-cell box-product item ";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getAdditionalItemClass", array(0 => $this->getAttribute($context["loop"], "index", array()), 1 => $this->getAttribute($context["loop"], "length", array())), "method"), "html", null, true);
            echo "\">
      ";
            // line 11
            echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getProductWidgetContent", array(0 => $context["product"]), "method");
            echo "
    </li>
  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['i'], $context['product'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "
  ";
        // line 15
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isShowMoreLink", array(), "method")) {
            // line 16
            echo "    <li class=\"more_link\">
      <a class=\"link\" href=\"";
            // line 17
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMoreLinkURL", array(), "method"), "html", null, true);
            echo "\">";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getMoreLinkText", array(), "method"), "html", null, true);
            echo "</a>
    </li>
  ";
        }
        // line 20
        echo "
</ul>
";
    }

    public function getTemplateName()
    {
        return "items_list/product/sidebar/small_thumbnails/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 20,  76 => 17,  73 => 16,  71 => 15,  68 => 14,  51 => 11,  46 => 10,  29 => 9,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Products list (sidebar variant)*/
/*  #}*/
/* */
/* {{ widget_list('itemsList.product.cart') }}*/
/* */
/* <ul class="list-body-sidebar products products-sidebar products-sidebar-small-thumbnails">*/
/* */
/*   {% for i, product in this.getSideBarData() %}*/
/*     <li class="product-cell box-product item {{ this.getAdditionalItemClass(loop.index, loop.length) }}">*/
/*       {{ this.getProductWidgetContent(product)|raw }}*/
/*     </li>*/
/*   {% endfor %}*/
/* */
/*   {% if this.isShowMoreLink() %}*/
/*     <li class="more_link">*/
/*       <a class="link" href="{{ this.getMoreLinkURL() }}">{{ this.getMoreLinkText() }}</a>*/
/*     </li>*/
/*   {% endif %}*/
/* */
/* </ul>*/
/* */

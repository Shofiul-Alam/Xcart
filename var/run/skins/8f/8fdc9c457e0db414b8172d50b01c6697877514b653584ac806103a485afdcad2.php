<?php

/* modules/QSL/FlyoutCategoriesMenu//body.twig */
class __TwigTemplate_2b325010689e395760967aec1bbdabbf9df2fb2977a4def8acdf97c71b1fc83a extends \XLite\Core\Templating\Twig\Template
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
        echo "<ul class=\"flyout-menu";
        if ( !$this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isSubtree", array(), "method")) {
            echo " catalog-categories catalog-categories-tree";
        } else {
            echo " sublevel";
        }
        echo "\">
  ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getCategories", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "rootId", array())), "method"));
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
        foreach ($context['_seq'] as $context["idx"] => $context["_category"]) {
            // line 6
            echo "    <li ";
            echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayItemClass", array(0 => $context["idx"], 1 => $this->getAttribute($context["loop"], "length", array()), 2 => $context["_category"]), "method");
            echo ">
      ";
            // line 7
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array("template" => ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDir", array(), "method") . "parts/category.link.twig"), "_category" => $context["_category"], "isShowTriangle" => (($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isShowTriangle", array(), "method") && $this->getAttribute($context["_category"], "hasSubcategories", array())) && $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isNotDeep", array(0 => $this->getAttribute($context["_category"], "depth", array())), "method"))))), "html", null, true);
            echo "
      ";
            // line 8
            if (($this->getAttribute($context["_category"], "hasSubcategories", array()) && $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isNotDeep", array(0 => $this->getAttribute($context["_category"], "depth", array())), "method"))) {
                // line 9
                echo "        ";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array("template" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getBody", array(), "method"), "rootId" => $this->getAttribute($context["_category"], "id", array()), "is_subtree" => "1"))), "html", null, true);
                echo "
      ";
            }
            // line 11
            echo "    </li>
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
        unset($context['_seq'], $context['_iterated'], $context['idx'], $context['_category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "  ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getViewList", array(0 => "topCategories.children", 1 => array("rootId" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getParam", array(0 => "rootId"), "method"), "is_subtree" => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getParam", array(0 => "is_subtree"), "method"))), "method"));
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
        foreach ($context['_seq'] as $context["idx"] => $context["w"]) {
            // line 14
            echo "    <li ";
            echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayListItemClass", array(0 => $context["idx"], 1 => $this->getAttribute($context["loop"], "length", array()), 2 => $context["w"]), "method");
            echo ">";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["w"], "display", array(), "method"), "html", null, true);
            echo "</li>
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
        unset($context['_seq'], $context['_iterated'], $context['idx'], $context['w'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "modules/QSL/FlyoutCategoriesMenu//body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 16,  95 => 14,  77 => 13,  62 => 11,  56 => 9,  54 => 8,  50 => 7,  45 => 6,  28 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Top categories tree*/
/*  #}*/
/* <ul class="flyout-menu{% if not this.isSubtree() %} catalog-categories catalog-categories-tree{% else %} sublevel{% endif %}">*/
/*   {% for idx, _category in this.getCategories(this.rootId) %}*/
/*     <li {{ this.displayItemClass(idx, loop.length, _category)|raw }}>*/
/*       {{ widget(template=this.getDir() ~ "parts/category.link.twig", _category=_category, isShowTriangle=this.isShowTriangle() and _category.hasSubcategories and this.isNotDeep(_category.depth)) }}*/
/*       {% if _category.hasSubcategories and this.isNotDeep(_category.depth) %}*/
/*         {{ widget(template=this.getBody(), rootId=_category.id, is_subtree='1') }}*/
/*       {% endif %}*/
/*     </li>*/
/*   {% endfor %}*/
/*   {% for idx, w in this.getViewList('topCategories.children', {'rootId': this.getParam('rootId'), 'is_subtree': this.getParam('is_subtree')}) %}*/
/*     <li {{ this.displayListItemClass(idx, loop.length, w)|raw }}>{{ w.display() }}</li>*/
/*   {% endfor %}*/
/* </ul>*/
/* */

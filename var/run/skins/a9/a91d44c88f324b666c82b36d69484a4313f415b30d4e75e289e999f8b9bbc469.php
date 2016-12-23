<?php

/* modules/QSL/FlyoutCategoriesMenu/parts/category.link.twig */
class __TwigTemplate_73774c1d416926ed1441e288d2ffedf6ed56d872619b6810cfd837aa3e023cdb extends \XLite\Core\Templating\Twig\Template
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
        echo "<a href=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "_category", array()), "link", array()), "html", null, true);
        echo "\" ";
        echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayLinkClass", array(0 => (isset($context["idx"]) ? $context["idx"] : null), 1 => $this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "length", array()), 2 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "_category", array())), "method");
        echo " title=\"";
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "_category", array()), "name", array()), "html", null, true);
        echo "\">
  <span class=\"category-label\">";
        // line 5
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "_category", array()), "name", array()), "html", null, true);
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isShowProductNum", array(), "method")) {
            echo " (";
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "_category", array()), "productsCount", array()), "html", null, true);
            echo ")";
        }
        echo "</span>
  ";
        // line 6
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isShowTriangle", array())) {
            // line 7
            echo "    <span class=\"icon-triangle\"></span>
  ";
        }
        // line 9
        echo "</a>
";
    }

    public function getTemplateName()
    {
        return "modules/QSL/FlyoutCategoriesMenu/parts/category.link.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 9,  39 => 7,  37 => 6,  28 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Category link*/
/*  #}*/
/* <a href="{{ this._category.link }}" {{ this.displayLinkClass(idx, loop.length, this._category)|raw }} title="{{ this._category.name }}">*/
/*   <span class="category-label">{{ this._category.name }}{% if this.isShowProductNum() %} ({{ this._category.productsCount }}){% endif %}</span>*/
/*   {% if this.isShowTriangle %}*/
/*     <span class="icon-triangle"></span>*/
/*   {% endif %}*/
/* </a>*/
/* */

<?php

/* items_list/product/parts/common.display-modes.twig */
class __TwigTemplate_e9453087459445157bc32964c4268068694999d78b588b1d17618d544431b1c0 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isDisplayModeSelectorVisible", array(), "method")) {
            // line 6
            echo "<div class=\"display-mode-box\">
  <div>
    <span class=\"display-mode-value\"><i class=\"fa ";
            // line 8
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDisplayModeCSS", array(0 => $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getParam", array(0 => "displayMode"), "method")), "method"), "html", null, true);
            echo "\"></i></span>
  </div>
  <ul class=\"display-modes grid-list\">
    ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "displayModes", array()));
            foreach ($context['_seq'] as $context["key"] => $context["name"]) {
                // line 12
                echo "      <li class=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDisplayModeLinkClassName", array(0 => $context["key"]), "method"), "html", null, true);
                echo "\">
        <a href=\"";
                // line 13
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getActionURL", array(0 => array("displayMode" => $context["key"])), "method"), "html", null, true);
                echo "\" class=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "\" title=\"";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($context["name"])), "html", null, true);
                echo "\">
          <i class=\"";
                // line 14
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDisplayModeCSS", array(0 => $context["key"]), "method"), "html", null, true);
                echo "\"></i>
          <span class=\"text\">";
                // line 15
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array($context["name"])), "html", null, true);
                echo "</span>
        </a>
      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "  </ul>

</div>
";
        }
    }

    public function getTemplateName()
    {
        return "items_list/product/parts/common.display-modes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 19,  55 => 15,  51 => 14,  43 => 13,  38 => 12,  34 => 11,  28 => 8,  24 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Products list display mode selector*/
/*  #}*/
/* */
/* {% if this.isDisplayModeSelectorVisible() %}*/
/* <div class="display-mode-box">*/
/*   <div>*/
/*     <span class="display-mode-value"><i class="fa {{ this.getDisplayModeCSS(this.getParam('displayMode')) }}"></i></span>*/
/*   </div>*/
/*   <ul class="display-modes grid-list">*/
/*     {% for key, name in this.displayModes %}*/
/*       <li class="{{ this.getDisplayModeLinkClassName(key) }}">*/
/*         <a href="{{ this.getActionURL({'displayMode': key}) }}" class="{{ key }}" title="{{ t(name) }}">*/
/*           <i class="{{ this.getDisplayModeCSS(key) }}"></i>*/
/*           <span class="text">{{ t(name) }}</span>*/
/*         </a>*/
/*       </li>*/
/*     {% endfor %}*/
/*   </ul>*/
/* */
/* </div>*/
/* {% endif %}*/
/* */

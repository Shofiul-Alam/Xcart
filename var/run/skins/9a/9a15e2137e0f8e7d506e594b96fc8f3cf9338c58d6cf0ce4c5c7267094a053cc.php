<?php

/* labels/body.twig */
class __TwigTemplate_b2f549c5fd8e8bae8ad17b3d8c5e4d94ffa007d1a072d5766706338062cc93fb extends \XLite\Core\Templating\Twig\Template
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
<ul class=\"labels\">
  ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getLabels", array(), "method"));
        foreach ($context['_seq'] as $context["key"] => $context["name"]) {
            // line 7
            echo "    <li class=\"label-";
            echo $context["key"];
            echo "\">
      ";
            // line 8
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array("template" => "label/body.twig", "labelContent" => $context["name"]))), "html", null, true);
            echo "
    </li>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "labels/body.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 11,  32 => 8,  27 => 7,  23 => 6,  19 => 4,);
    }
}
/* {##*/
/*  # Labels*/
/*  #}*/
/* */
/* <ul class="labels">*/
/*   {% for key, name in this.getLabels() %}*/
/*     <li class="label-{{ key|raw }}">*/
/*       {{ widget(template='label/body.twig', labelContent=name) }}*/
/*     </li>*/
/*   {% endfor %}*/
/* </ul>*/
/* */

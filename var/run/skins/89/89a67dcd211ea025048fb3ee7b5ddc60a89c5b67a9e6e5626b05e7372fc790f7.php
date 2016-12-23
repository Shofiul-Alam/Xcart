<?php

/* layout/content/category_description.twig */
class __TwigTemplate_843ba1a1083635e75c4dce70f680b8994d40158f501c793a288501cb95ce6f42 extends \XLite\Core\Templating\Twig\Template
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
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDescription", array(), "method")) {
            // line 6
            echo "<div class=\"category-description\">";
            echo $this->getAttribute((isset($context["this"]) ? $context["this"] : null), "getDescription", array(), "method");
            echo "</div>
";
        }
    }

    public function getTemplateName()
    {
        return "layout/content/category_description.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 6,  22 => 5,  19 => 4,);
    }
}
/* {##*/
/*  # Category page*/
/*  #}*/
/* */
/* {% if this.getDescription() %}*/
/* <div class="category-description">{{ this.getDescription()|raw }}</div>*/
/* {% endif %}*/
/* */

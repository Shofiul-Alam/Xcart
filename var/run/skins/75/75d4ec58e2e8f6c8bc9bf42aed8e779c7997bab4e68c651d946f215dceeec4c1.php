<?php

/* layout/content/category_banner.twig */
class __TwigTemplate_5f270a7a9b13c54d481ea099913ad9806a670ce2a073a2ba880e587c1ad3284c extends \XLite\Core\Templating\Twig\Template
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
        echo "<div class=\"category-banner\">
    <div class=\"category-banner_image-wrapper lazy-load\">
        <div class=\"additional-wrapper\">
            ";
        // line 7
        echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), array($this->env, $context, array(0 => "\\XLite\\View\\Image", "image" => $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "category", array()), "banner", array()), "centerImage" => "1", "alt" => $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "category", array()), "name", array())))), "html", null, true);
        echo "
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "layout/content/category_banner.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 7,  19 => 4,);
    }
}
/* {##*/
/*  # Category banner*/
/*  #}*/
/* <div class="category-banner">*/
/*     <div class="category-banner_image-wrapper lazy-load">*/
/*         <div class="additional-wrapper">*/
/*             {{ widget('\\XLite\\View\\Image', image=this.category.banner, centerImage='1', alt=this.category.name) }}*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */

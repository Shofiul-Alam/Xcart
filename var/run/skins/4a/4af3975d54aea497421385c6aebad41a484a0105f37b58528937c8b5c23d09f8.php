<?php

/* header/parts/meta_mobile_capable.twig */
class __TwigTemplate_c11b679eb274d5d67193d86ff217a2352fe331860ef44b30aeddc7d154f53a01 extends \XLite\Core\Templating\Twig\Template
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
        echo "
<meta name=\"apple-mobile-web-app-capable\"   content=\"yes\" />
<meta name=\"mobile-web-app-capable\"         content=\"yes\" />";
    }

    public function getTemplateName()
    {
        return "header/parts/meta_mobile_capable.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 6,);
    }
}
/* {##*/
/*  # Head list children*/
/*  #*/
/*  # @ListChild (list="head", weight="700")*/
/*  #}*/
/* */
/* <meta name="apple-mobile-web-app-capable"   content="yes" />*/
/* <meta name="mobile-web-app-capable"         content="yes" />*/
